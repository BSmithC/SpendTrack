<template>
    <div class="tooltip-container" @mouseenter="showTooltip" @mouseleave="hideTooltip">
        <slot></slot>
        <Teleport to="body">
            <div v-show="show" ref="tooltipRef" class="tooltip" :class="[position]"
                :style="[customStyle, positionStyle]">
                {{ text }}
            </div>
        </Teleport>
    </div>
</template>

<script>
export default {
    name: 'Tooltip',
    props: {
        text: {
            type: String,
            required: true
        },
        position: {
            type: String,
            default: 'top',
            validator: (value) => ['top', 'right', 'bottom', 'left'].includes(value)
        },
        backgroundColor: {
            type: String,
            default: '#333'
        },
        textColor: {
            type: String,
            default: '#fff'
        }
    },
    data() {
        return {
            show: false,
            positionStyle: {},
            elementPosition: {
                top: 0,
                left: 0,
                width: 0,
                height: 0
            }
        }
    },
    computed: {
        customStyle() {
            return {
                backgroundColor: this.backgroundColor,
                color: this.textColor,
                '--tooltip-bg': this.backgroundColor
            }
        }
    },
    methods: {
        updatePosition() {
            if (!this.$el) return;

            const rect = this.$el.getBoundingClientRect();
            this.elementPosition = {
                top: rect.top,
                left: rect.left,
                width: rect.width,
                height: rect.height
            };

            const tooltipEl = this.$refs.tooltipRef;
            if (!tooltipEl) return;

            const tooltipRect = tooltipEl.getBoundingClientRect();

            // Calcula la posición basada en la posición elegida
            switch (this.position) {
                case 'top':
                    this.positionStyle = {
                        position: 'fixed',
                        left: `${rect.left + rect.width / 2}px`,
                        top: `${rect.top}px`,
                        transform: `translateX(-50%) translateY(calc(-100% - 8px))`
                    };
                    break;
                case 'right':
                    this.positionStyle = {
                        position: 'fixed',
                        left: `${rect.right}px`,
                        top: `${rect.top + rect.height / 2}px`,
                        transform: `translateY(-50%) translateX(8px)`
                    };
                    break;
                case 'bottom':
                    this.positionStyle = {
                        position: 'fixed',
                        left: `${rect.left + rect.width / 2}px`,
                        top: `${rect.bottom}px`,
                        transform: `translateX(-50%) translateY(8px)`
                    };
                    break;
                case 'left':
                    this.positionStyle = {
                        position: 'fixed',
                        left: `${rect.left}px`,
                        top: `${rect.top + rect.height / 2}px`,
                        transform: `translateY(-50%) translateX(calc(-100% - 8px))`
                    };
                    break;
            }
        },
        showTooltip() {
            this.updatePosition();
            this.show = true;
        },
        hideTooltip() {
            this.show = false;
        }
    }
}
</script>

<style scoped>
.tooltip-container {
    position: relative;
    display: inline-block;
}

.tooltip {
    position: fixed;
    z-index: 9999;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    line-height: 1.4;
    white-space: nowrap;
    pointer-events: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    transition: opacity 0.3s;
}

/* Flechas para el tooltip */
.tooltip::after {
    content: '';
    position: absolute;
    border-width: 5px;
    border-style: solid;
}

.tooltip.top::after {
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-color: var(--tooltip-bg, #333) transparent transparent transparent;
}

.tooltip.right::after {
    top: 50%;
    right: 100%;
    margin-top: -5px;
    border-color: transparent var(--tooltip-bg, #333) transparent transparent;
}

.tooltip.bottom::after {
    bottom: 100%;
    left: 50%;
    margin-left: -5px;
    border-color: transparent transparent var(--tooltip-bg, #333) transparent;
}

.tooltip.left::after {
    top: 50%;
    left: 100%;
    margin-top: -5px;
    border-color: transparent transparent transparent var(--tooltip-bg, #333);
}
</style>
