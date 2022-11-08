<template>
	<layout ref="layout">
		<div slot="component-view" class="slot-inventario-productos">
			<div class="card">
				<headerClose :title="'PRODUCTOS'"></headerClose>
				<div class="card card-body">
					<div class="text-center mb-1">
						<button
							class="btn icon icon_left btn-action"
							style="font-size: 15px"
							title="Nuevo"
							@click="Nuevo"
						>
							<i class="bi bi-plus"></i>
							NUEVO
						</button>
					</div>

					<div
						class="row justify-content-md-center"
						style="background-color: #e6ecff; border-radius: 20px"
					>
						<div class="card-title">LISTA DE RESULTADOS</div>
						<div
							class="card m-2 col-md-2 p-0 pb-1"
							v-for="(item, index) in productos"
							:key="index"
						>
							<div class="card-content">
								<h4 class="card-title">{{ item.codigo }}</h4>
								<h4 class="card-title">{{ item.descripcion }}</h4>
								<table class="table">
									<thead>
										<tr>
											<th>Stock</th>
											<th>P.c.</th>
											<th>P.v.</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td align="center">{{ item.cantidad }}</td>
											<td align="center">{{ item.precio_compra }}</td>
											<td align="center">{{ item.precio_venta }}</td>
										</tr>
									</tbody>
								</table>

								<div class="text-center">
									<div class="btn-group" role="group">
										<button
											class="btn icon btn-warning"
											title="Editar"
											@click="Editar(item)"
										>
											<i class="bi bi-pencil"></i>
										</button>
										<button
											class="btn icon btn-danger"
											title="Eliminar"
											@click="Eliminar(item.id)"
										>
											<i class="bi bi-trash"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<mdlDetalleProducto ref="mdlDetalleProducto"></mdlDetalleProducto>
		</div>
	</layout>
</template>

<script>
import layout from "./../Components/layout";
import headerClose from "./../Components/header-close";
import mdlDetalleProducto from "./Components/mdlDetalleProducto";

export default {
	components: { layout, headerClose, mdlDetalleProducto },

	data() {
		return {
			productos: [],
		};
	},

	mounted() {
		this.ListarProductos();
	},
	methods: {
		async ListarProductos() {
			let self = this;

			await axios.get("/api/inventario/productos").then(function (response) {
				self.productos = response.data.data;
			});
		},
		Nuevo() {
			let modulo = this.$refs.mdlDetalleProducto;

			modulo.titulo_modal = "NUEVO PRODUCTO";
			modulo.modo = "NUEVO";
			modulo.ListarRecursos();
			modulo.Resetear();
			$("#mdlDetalleProducto").modal("show");
		},

		async Editar(item) {
			let modulo = this.$refs.mdlDetalleProducto;

			modulo.titulo_modal = "EDITAR PRODUCTO";
			modulo.modo = "EDITAR";
			modulo.ListarRecursos();

			let frmProducto = modulo.frmProducto;
			frmProducto.id = item.id;
			frmProducto.codigo = item.codigo;
			frmProducto.descripcion = item.descripcion;
			frmProducto.cantidad = item.cantidad;
			frmProducto.marca_id = item.marca_id;
			frmProducto.categoria_id = item.categoria_id;
			frmProducto.precio_compra = item.precio_compra;
			frmProducto.precio_venta = item.precio_venta;
			frmProducto.fecha_creacion = item.created_at;

			$("#mdlDetalleProducto").modal("show");
		},

		Eliminar(id) {
			let self = this;
			Swal.fire({
				title: "ELIMINAR PRODUCTO",
				text: "¿Desea continuar?",
				confirmButtonText: "Si",
				showCancelButton: true,
				cancelButtonText: "No",
				allowOutsideClick: false,
				showLoaderOnConfirm: true,
				preConfirm: () => {
					return axios
						.delete("/api/inventario/productos/" + id)
						.then(function (response) {
							self.ListarProductos();
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
.slot-inventario-productos {
	width: 90% !important;
	margin-left: 5% !important;
}
</style>
