<template>
	<layout ref="layout">
		<div slot="component-view" class="slot-inventario-marcas">
			<div class="card">
				<headerClose :title="'MARCAS'"></headerClose>
				<div class="card card-body">
					<div class="row mb-1">
						<div class="col-md-2">
							<button
								class="btn icon icon_left btn-action"
								title="Nueva MARCA"
								@click="NuevaMarca"
							>
								<i class="bi bi-plus-circle"></i>
								NUEVO
							</button>
						</div>
					</div>

					<div class="card-title">LISTA DE RESULTADOS</div>
					<table
						class="table table-hover"
						id="tblMarcas"
						width="100% !important"
					>
						<thead>
							<tr>
								<th>#</th>
								<th>EDITAR</th>
								<th>MARCA</th>
								<th>ESTADO</th>
							</tr>
						</thead>
						<tbody>
							<tr
								v-for="(item, index) in marcas"
								:key="index"
								class="table-bordered"
							>
								<td align="center">{{ index + 1 }}</td>
								<td align="center">
									<button
										class="btn icon icon_left btn-warning"
										title="Editar MARCA"
										@click="EditarMarca(item)"
									>
										<i class="bi bi-pencil-square"></i>
									</button>
								</td>
								<td>{{ item.marca }}</td>
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
				id="mdlMarca"
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
							:nombre_modal="'mdlMarca'"
						></headerCloseModal>
						<div class="modal-body">
							<div class="row">
								<div class="form-group col-md-12">
									<label>MARCA</label>
									<input
										type="text"
										class="form-control mayus"
										v-model="frmMarca.marca"
										:class="[
											submited
												? $v.frmMarca.marca.$invalid
													? 'is-invalid'
													: 'is-valid'
												: '',
										]"
									/>
								</div>
								<div
									class="form-group col-md-6"
									v-if="frmMarca.modo == 'EDITAR'"
								>
									<div class="form-check">
										<div class="checkbox">
											<input
												type="checkbox"
												class="form-check-input"
												v-model="frmMarca.habilitado"
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
								title="Guardar MARCA"
								@click="GuardarMarca"
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

export default {
	components: { layout, headerClose, headerCloseModal },
	props: {},
	data() {
		return {
			marcas: [],

			submited: false,
			titulo_modal: "NUEVA MARCA",
			frmMarca: {
				modo: "NUEVO",
				id: null,
				marca: null,

				habilitado: 0,
			},
		};
	},
	validations: {
		frmMarca: {
			marca: { required },
		},
	},

	mounted() {
		this.ListarMarcas();
	},
	methods: {
		LimpiarDatos() {
			this.titulo_modal = "NUEVA MARCA";
			this.frmMarca.modo = "NUEVO";
			this.frmMarca.id = null;
			this.frmMarca.marca = null;
			this.frmMarca.habilitado = 1;
		},
		async ListarMarcas(sede_id) {
			let self = this;
			await axios
				.get("/api/mantenimiento/inv/marcas")
				.then(function (response) {
					self.marcas = response.data.data;
				});
		},
		NuevaMarca() {
			this.LimpiarDatos();
			$("#mdlMarca").modal("show");
		},
		EditarMarca(item) {
			this.titulo_modal = "EDITAR MARCA";

			this.frmMarca.modo = "EDITAR";
			this.frmMarca.id = item.id;
			this.frmMarca.marca = item.marca;
			this.frmMarca.habilitado = item.habilitado;

			$("#mdlMarca").modal("show");
		},
		async GuardarMarca() {
			let self = this;
			this.submited = true;

			if (this.$v.frmMarca.$invalid) {
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
					if (self.frmMarca.modo == "NUEVO") {
						method = axios.post("/api/mantenimiento/inv/marcas", {
							frmMarca: self.frmMarca,
						});
					} else {
						method = axios.put(
							"/api/mantenimiento/inv/marcas/" + self.frmMarca.id,
							{
								frmMarca: self.frmMarca,
							}
						);
					}

					return method
						.then((response) => {
							self.submited = false;
							self.ListarMarcas();
							$("#mdlMarca").modal("hide");
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
.slot-inventario-marcas {
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
