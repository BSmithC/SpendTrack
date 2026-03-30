<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold">
                New Budget
            </h2>
        </template>

        <div class="max-w-6xl mx-auto p-6 space-y-6">
            <!-- Clientes -->
            <Card>
                <CardHeader class="flex space-y-5  ">
                    <div class="grid grid-cols-4 gap-4">

                        <div>
                            <Label class="text-foreground">Tipo de Factura<span class="text-red-500"> *</span> </Label>
                            <Select v-model="form.type">
                                <SelectTrigger class="w-full ">
                                    <SelectValue placeholder="Contado" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Contado">Contado</SelectItem>
                                    <SelectItem v-if="form.client_id != 1" value="Crédito">Crédito</SelectItem>
                                </SelectContent>
                            </Select>
                        </div>

                        <div v-if="form.type == 'Crédito'">
                            <Label class="text-foreground">Inicial</Label>
                            <Input type="number" min="1" v-model.number="form.initial" />
                            <InputError :message="form.errors.initial" />
                        </div>

                        <div class="p-6">
                            <Button type="button" @click="addDetail()">
                                Agregar Productos
                            </Button>
                        </div>
                    </div>

                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Producto</TableHead>
                                <TableHead class="text-center">Precio</TableHead>
                                <TableHead class="text-center">Cantidad</TableHead>
                                <TableHead class="text-center">Acción</TableHead>
                            </TableRow>
                        </TableHeader>

                        <TableBody>
                            <TableRow v-for="(item, index) in form.details" :key="index">

                                <TableCell class="text-center w-25">
                                    <Input type="text" v-model.number="item.name" />
                                    <InputError :message="form.errors[`details.${index}.name`]" />
                                </TableCell>

                                <TableCell class="text-center w-25">
                                    <Input type="number" min="1" v-model.number="item.unitary_price" />
                                    <InputError :message="form.errors[`details.${index}.unitary_price`]" />
                                </TableCell>

                                <TableCell class="text-center w-20">
                                    <Input type="number" min="1" v-model.number="item.quantity" />
                                    <InputError :message="form.errors[`details.${index}.quantity`]" />
                                </TableCell>

                                <TableCell class="text-center">
                                    <Button size="sm" variant="destructive" @click="removeItem(index)">
                                        <DeleteIcon />
                                    </Button>
                                </TableCell>
                            </TableRow>

                            <TableRow v-if="!form.details.length">
                                <TableCell colspan="8" class="text-center text-muted-foreground">
                                    No hay productos agregados
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>

                    <Separator />
                    <div class="flex justify-end mt-5">
                        <div class="w-80 space-y-2">
                            <Separator />

                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span>{{ currency(total) }}</span>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- ACCIONES -->
            <div class="flex justify-end gap-3">
                <Button variant="outline" as-child>
                    <Link href="/Budget">Cancel</Link>
                </Button>
                <Button variant="outline" type="button" :disabled="!form.details.length || form.processing"
                    @click="submit">
                    Save Budget
                </Button>
            </div>

        </div>
        <Dialog v-model:open="showInitialModal">

            <DialogContent class=" bg-background text-foreground border-border shadow-lg">
                <DialogHeader>
                    <DialogTitle class="text-foreground">Cuentas por Cobrar</DialogTitle>
                </DialogHeader>

                <div class="py-4 space-y-4">

                    <Label class="text-foreground">Inicial</Label>
                    <Input type="number" min="1" @input="checkInitial()" v-model.number="form.initial" />
                    <InputError :message="form.errors.initial" />
                    <Label class="text-foreground">Cantidad de pagos</Label>
                    <Input type="number" min="1" @input="checkFees()" v-model.number="form.fees" />
                    <InputError :message="form.errors.fees" />
                    <div class="flex justify-between">
                        <span>Pagos de:</span>
                        <span>{{ currency(fee_amount) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span>{{ currency(totalCredit) }}</span>
                    </div>
                </div>
                <div class="flex justify-end gap-3">

                    <Button type="button" :disabled="!form.details.length || form.processing" @click="submitCredit">
                        Save Budget
                    </Button>
                </div>

            </DialogContent>
        </Dialog>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import { Textarea } from '@/Components/ui/textarea'
import { Label } from '@/Components/ui/label'
import { ref } from 'vue'
import InputError from '@/Components/InputError.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card'
import { Table, TableBody, TableCell, TableHead, TableRow } from '@/Components/ui/table'
import { Separator } from '@/Components/ui/separator/'
import TableHeader from '@/Components/ui/table/TableHeader.vue'
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue'
import {
    Select,
    SelectTrigger,
    SelectValue,
    SelectContent,
    SelectItem,
} from '@/Components/ui/select'
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
export default {
    props: {

    },
    components: {
        Button,
        AuthenticatedLayout,
        Input,
        Textarea,
        Label,
        Link,
        InputError,
        Card,
        CardHeader,
        CardTitle,
        CardContent,
        Table,
        TableHead,
        TableRow,
        TableBody,
        TableCell,
        Separator,
        TableHeader,
        DeleteIcon,
        Select,
        SelectTrigger,
        SelectValue,
        SelectContent,
        SelectItem,
        Dialog,
        DialogContent,
        DialogHeader,
        DialogTitle,
        DialogTrigger,

    },
    data() {
        return {
            form: useForm({
                total: 0,
                subtotal: 0,
                taxes: 0,
                details: [],
                type: 'Contado',
                initial: null,
                amount_of_payments: 1,
                status: true,
            }),
            showInitialModal: ref(null),
        }
    },
    computed: {
        total() {
            return this.form.details.reduce((sum, item) => {
                return sum + (item.unitary_price * item.quantity)
            }, 0)
        },
        totalCredit() {
            return this.total - (this.form.initial || 0)
        },
        fee_amount() {
            if (this.form.fees > 0) {
                return this.totalCredit / this.form.fees
            }
            return 0
        }
    },
    methods: {
        subtotal(item) {
            if (item.unitary_price && item.quantity) {
                return item.unitary_price * item.quantity
            }
            return 0
        },
        checkInitial() {
            if (this.form.initial >= this.total) {
                this.form.errors.initial = "El Inicial debe ser menor al monto total";
                this.form.initial = 0;
            }
        },
        checkFees() {
            if (this.form.fees <= 0) {
                this.form.errors.fees = "La cantidad de pagos debe ser mayor a 0";
                this.form.fees = 1;
            }
        },
        addDetail() {
            this.form.details.push({
                detail_id: null,
                name: '',
                quantity: 1,
                unitary_price: 0,
                budget_id: null,
                amount: 0,
                total: 0
            })
        },

        removeItem(index) {
            this.form.details.splice(index, 1)
        },

        currency(value) {
            return new Intl.NumberFormat('es-DO', {
                style: 'currency',
                currency: 'DOP',
            }).format(value)
        },
        submit() {
            if (this.form.type === 'Crédito') {
                this.showInitialModal = true
                return
            }
            this.prepareAndSubmit()
        },
        prepareAndSubmit() {
            this.form.subtotal = this.total
            this.form.taxes = this.form.apply_itbis ? this.form.subtotal * this.taxRate : 0
            this.form.total = this.form.subtotal + this.form.taxes
            this.form.amount_of_payments = this.form.type === 'Crédito' ? this.form.fees : 1

            this.form.details = this.form.details.map(detail => ({
                budget_id: detail.budget_id,
                amount: detail.unitary_price,
                quantity: detail.quantity,
                total: detail.unitary_price * detail.quantity
            }))

            this.form.post('/Budget', {
                onSuccess: () => {
                    this.showInitialModal = false
                }
            })
        },
        submitCredit() {
            this.showInitialModal = false
            this.prepareAndSubmit()
        }
    },

}
</script>
