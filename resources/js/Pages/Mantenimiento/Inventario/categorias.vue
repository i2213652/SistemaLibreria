<template>
	<layout ref="layout">
		<div slot="component-view" class="slot-inventario-categorias">
			<div class="card">
				<headerClose :title="'CATEGORÍAS'"></headerClose>
				<div class="card card-body">
					<div class="row mb-1">
						<div class="col-md-2">
							<button
								class="btn icon icon_left btn-action"
								title="Nueva CATEGORÍA"
								@click="NuevaCategoria"
							>
								<i class="bi bi-plus-circle"></i>
								NUEVO
							</button>
						</div>
					</div>

					<div class="card-title">LISTA DE RESULTADOS</div>
					<table
						class="table table-hover"
						id="tblCategorias"
						width="100% !important"
					>
						<thead>
							<tr>
								<th>#</th>
								<th>EDITAR</th>
								<th>CATEGORÍA</th>
								<th>ESTADO</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="(item, index) in categorias"
								:key="index"
								class="table-bordered"
							>
								<td align="center">{{ index + 1 }}</td>
								<td align="center">
									<button
										class="btn icon icon_left btn-warning"
										title="Editar CATEGORÍA"
										@click="EditarCategoria(item)"
									>
										<i class="bi bi-pencil-square"></i>
									</button>
								</td>
								<td>{{ item.categoria }}</td>
								<td
									align="center"
									class="bolder"
									:class="[
										item.habilitado == 1 ? 'habilitado' : 'deshabilitado',
									]"
								>
									{{ item.habilitado == 1 ? "HABILITADO" : "DESHABILITADO" }}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div
				class="modal fade text-left"
				id="mdlCategoria"
				tabindex="-1"
				role="dialog"
				aria-hidden="true"
				data-bs-backdrop="false"
			>
				<div
					class="
						modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md
					"
					role="document"
				>
					<div class="modal-content">
						<headerCloseModal
							:titulo_modal="titulo_modal"
							:nombre_modal="'mdlCategoria'"
						></headerCloseModal>
						<div class="modal-body">
							<div class="row">
								<div class="form-group col-md-12">
									<label>CATEGORÍA</label>
									<input
										type="text"
										class="form-control mayus"
										v-model="frmCategoria.categoria"
										:class="[
											submited
												? $v.frmCategoria.categoria.$invalid
													? 'is-invalid'
													: 'is-valid'
												: '',
										]"
									/>
								</div>
								<div
									class="form-group col-md-6"
									v-if="frmCategoria.modo == 'EDITAR'"
								>
									<div class="form-check">
										<div class="checkbox">
											<input
												type="checkbox"
												class="form-check-input"
												v-model="frmCategoria.habilitado"
												id="chbHabilitado"
											/>
											<label for="chbHabilitado">HABILITADO</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button
								class="btn icon icon_left btn-primary"
								title="Guardar CATEGORÍA"
								@click="GuardarCategoria"
							>
								<i class="bi bi-save"></i>
								GUARDAR
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</layout>
</template>

<script>
import layout from "./../../Components/layout";
import headerClose from "./../../Components/header-close";
import headerCloseModal from "./../../Components/header-close-modal";
import { required } from "vuelidate/lib/validators";
const noZero = (value) => value != 0;

export default {
	components: { layout, headerClose, headerCloseModal },
	props: {},
	data() {
		return {
			categorias: [],

			submited: false,
			titulo_modal: "NUEVA CATEGORÍA",
			frmCategoria: {
				modo: "NUEVO",
				id: null,
				categoria: null,
				habilitado: 0,
			},
		};
	},
	validations: {
		frmCategoria: {
			categoria: { required },
		},
	},

	mounted() {
		this.ListarCategorias();
	},
	methods: {
		LimpiarDatos() {
			this.titulo_modal = "NUEVA CATEGORÍA";
			this.frmCategoria.modo = "NUEVO";
			this.frmCategoria.id = null;
			this.frmCategoria.categoria = null;
			this.frmCategoria.habilitado = 1;
		},
		async ListarCategorias() {
			let self = this;
			await axios
				.get("/api/mantenimiento/inv/categorias")
				.then(function (response) {
					self.categorias = response.data.data;
				});
		},
		NuevaCategoria() {
			this.LimpiarDatos();
			$("#mdlCategoria").modal("show");
		},
		EditarCategoria(item) {
			this.titulo_modal = "EDITAR CATEGORÍA";

			this.frmCategoria.modo = "EDITAR";
			this.frmCategoria.id = item.id;
			this.frmCategoria.categoria = item.categoria;
			this.frmCategoria.habilitado = item.habilitado;

			$("#mdlCategoria").modal("show");
		},
		async GuardarCategoria() {
			let self = this;
			this.submited = true;

			if (this.$v.frmCategoria.$invalid) {
				Swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}

			Swal.fire({
				title: "GUARDAR INFORMACIÓN",
				text: "¿Desea continuar?",
				confirmButtonText: "Si",
				showCancelButton: true,
				cancelButtonText: "No",
				allowOutsideClick: false,
				showLoaderOnConfirm: true,
				preConfirm: () => {
					let method = null;
					if (self.frmCategoria.modo == "NUEVO") {
						method = axios.post("/api/mantenimiento/inv/categorias", {
							frmCategoria: self.frmCategoria,
						});
					} else {
						method = axios.put(
							"/api/mantenimiento/inv/categorias/" + self.frmCategoria.id,
							{
								frmCategoria: self.frmCategoria,
							}
						);
					}

					return method
						.then((response) => {
							self.submited = false;
							self.ListarCategorias();
							$("#mdlCategoria").modal("hide");
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

<style>
.slot-inventario-categorias {
	width: 70% !important;
	margin-left: 15% !important;
}

.habilitado {
	color: green !important;
}

.deshabilitado {
	color: red !important;
}
</style>
