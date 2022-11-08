
<template>
	<div
		class="modal fade text-left"
		id="mdlDetalleProducto"
		tabindex="-1"
		role="dialog"
		aria-hidden="true"
		data-bs-backdrop="false"
	>
		<div
			class="
				modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg
			"
			role="document"
		>
			<div class="modal-content">
				<headerCloseModal
					:titulo_modal="titulo_modal"
					:nombre_modal="'mdlDetalleProducto'"
				></headerCloseModal>
				<div class="modal-body">
					<div class="row">
						<div class="form-group col-md-3">
							<label>Código</label>
							<input
								type="text"
								class="form-control text-center"
								:value="frmProducto.codigo"
								disabled
							/>
						</div>
						<div class="form-group col-md-9">
							<label>Descripción</label>
							<input
								type="text"
								class="form-control mayus"
								v-model="frmProducto.descripcion"
								:class="[
									submited
										? $v.frmProducto.descripcion.$invalid
											? 'is-invalid'
											: 'is-valid'
										: '',
								]"
								:disabled="modo != 'NUEVO'"
							/>
						</div>

						<div class="form-group col-md-6">
							<label>Marca</label>
							<select
								class="form-select"
								v-model="frmProducto.marca_id"
								:class="[
									submited
										? $v.frmProducto.marca_id.$invalid
											? 'is-invalid'
											: 'is-valid'
										: '',
								]"
								:disabled="modo != 'NUEVO'"
							>
								<option value="0" disabled selected>Seleccione...</option>
								<option
									v-for="(item, index) in marcas"
									:key="index"
									:value="item.id"
								>
									{{ item.marca }}
								</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Categoría</label>
							<select
								class="form-select"
								v-model="frmProducto.categoria_id"
								:class="[
									submited
										? $v.frmProducto.categoria_id.$invalid
											? 'is-invalid'
											: 'is-valid'
										: '',
								]"
								:disabled="modo != 'NUEVO'"
							>
								<option value="0" disabled selected>Seleccione...</option>
								<option
									v-for="(item, index) in categorias"
									:key="index"
									:value="item.id"
								>
									{{ item.categoria }}
								</option>
							</select>
						</div>

						<div class="form-group col-md-4">
							<label>Cantidad</label>
							<div class="input-group mb-3">
								<button
									class="btn btn-primary"
									type="button"
									@click="frmProducto.cantidad--"
									:disabled="modo != 'NUEVO'"
								>
									<i class="bi bi-dash"></i>
								</button>
								<input
									type="text"
									class="form-control text-center"
									v-model.number="frmProducto.cantidad"
									:class="[
										submited
											? $v.frmProducto.cantidad.$invalid
												? 'is-invalid'
												: 'is-valid'
											: '',
									]"
									:disabled="modo != 'NUEVO'"
								/>
								<button
									class="btn btn-primary"
									type="button"
									@click="frmProducto.cantidad++"
									:disabled="modo != 'NUEVO'"
								>
									<i class="bi bi-plus"></i>
								</button>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label>Precio (COMPRA)</label>
							<div class="input-group mb-3">
								<button
									class="btn btn-primary"
									type="button"
									@click="frmProducto.precio_compra--"
								>
									<i class="bi bi-dash"></i>
								</button>
								<input
									type="text"
									class="form-control text-center"
									v-model.number="frmProducto.precio_compra"
								/>
								<button
									class="btn btn-primary"
									type="button"
									@click="frmProducto.precio_compra++"
								>
									<i class="bi bi-plus"></i>
								</button>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label>Precio (VENTA)</label>
							<div class="input-group mb-3">
								<button
									class="btn btn-primary"
									type="button"
									@click="frmProducto.precio_venta--"
								>
									<i class="bi bi-dash"></i>
								</button>
								<input
									type="text"
									class="form-control text-center"
									v-model.number="frmProducto.precio_venta"
								/>
								<button
									class="btn btn-primary"
									type="button"
									@click="frmProducto.precio_venta++"
								>
									<i class="bi bi-plus"></i>
								</button>
							</div>
						</div>
						<div class="form-group col-md-3" v-if="modo == 'EDITAR'">
							<label>Fecha de registro</label>
							<input
								type="text"
								class="form-control text-center"
								:value="frmProducto.fecha_creacion"
								disabled
							/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button
						class="btn icon icon_left btn-primary"
						title="Guardar PRODUCTO"
						@click="Guardar"
					>
						<i class="bi bi-save"></i>
						GUARDAR
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import headerCloseModal from "../../Components/header-close-modal.vue";
import { required } from "vuelidate/lib/validators";
const noZero = (value) => value != 0;

export default {
	components: { headerCloseModal },
	data() {
		return {
			submited: false,
			titulo_modal: null,
			modo: null,

			marcas: [],
			categorias: [],

			frmProducto: {
				id: null,
				codigo: null,
				descripcion: null,
				marca_id: 0,
				categoria_id: 0,
				cantidad: this.roundTo(0, 2),
				precio_compra: this.roundTo(0, 2),
				precio_venta: this.roundTo(0, 2),
				fecha_creacion: null,
			},
		};
	},
	validations: {
		frmProducto: {
			descripcion: { required },
			marca_id: { noZero },
			categoria_id: { noZero },
			cantidad: { noZero },
			precio_compra: { noZero },
			precio_venta: { noZero },
		},
	},
	computed: {
		cantidad() {
			return this.frmProducto.cantidad;
		},
		precio_compra() {
			return this.frmProducto.precio_compra;
		},
		precio_venta() {
			return this.frmProducto.precio_venta;
		},
	},
	watch: {
		cantidad(value) {
			return (this.frmProducto.cantidad = this.roundTo(value, 2));
		},
		precio_compra(value) {
			return (this.frmProducto.precio_compra = this.roundTo(value, 2));
		},
		precio_venta(value) {
			return (this.frmProducto.precio_venta = this.roundTo(value, 2));
		},
	},
	methods: {
		roundTo(value, decimals) {
			let valor = 0;
			let decimales = decimals;

			if (value && value >= 0) {
				valor = value;
			}
			return parseFloat(valor).toFixed(decimales);
		},

		async ListarRecursos() {
			let self = this;
			let params = true;

			await axios
				.get("/api/mantenimiento/inv/marcas/" + params)
				.then(function (response) {
					self.marcas = response.data.data;
				});
			await axios
				.get("/api/mantenimiento/inv/categorias/" + params)
				.then(function (response) {
					self.categorias = response.data.data;
				});
		},
		Resetear() {
			this.frmProducto.id = null;
			this.frmProducto.codigo = null;
			this.frmProducto.descripcion = null;
			this.frmProducto.marca_id = 0;
			this.frmProducto.categoria_id = 0;
			this.frmProducto.cantidad = this.roundTo(0, 2);
			this.frmProducto.precio_compra = this.roundTo(0, 2);
			this.frmProducto.precio_venta = this.roundTo(0, 2);
			this.frmProducto.fecha_creacion = null;
		},

		async Guardar() {
			let self = this;
			this.submited = true;

			if (this.$v.frmProducto.$invalid) {
				Swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}

			Swal.fire({
				title: "GUARDAR PRODUCTO",
				text: "¿Desea continuar?",
				confirmButtonText: "Si",
				showCancelButton: true,
				cancelButtonText: "No",
				allowOutsideClick: false,
				showLoaderOnConfirm: true,
				preConfirm: () => {
					let method = null;
					if (self.modo == "NUEVO") {
						method = axios.post("/api/inventario/productos", {
							frmProducto: self.frmProducto,
						});
					} else {
						method = axios.put(
							"/api/inventario/productos/" + self.frmProducto.id,
							{
								frmProducto: self.frmProducto,
							}
						);
					}

					return method
						.then((response) => {
							self.submited = false;
							self.$parent.$parent.ListarProductos();
							$("#mdlDetalleProducto").modal("hide");
						})
						.catch((error) => {
							Swal.showValidationMessage(`Ha ocurrido un error: ${error}`);
						});
				},
				allowOutsideClick: () => !Swal.isLoading(),
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						icon: "success",
						title: "¡ÉXITO!",
						timer: 1200,
						showConfirmButton: false,
					});
				}
			});
		},
	},
};
</script>

<style lang="css">
</style>

