<template>
	<div class="card-header d-flex align-items-center justify-content-between">
		<strong>{{ titulo_modal }}</strong>
		<button
			type="button"
			class="btn btn-purple"
			style="border-radius: 50%"
			@click="CerrarModal(nombre_modal)"
		>
			<span class="icon">
				<i class="bi bi-x-lg" style="font-weight: bolder"></i>
			</span>
		</button>
	</div>
</template>

<script>
export default {
	props: {
		titulo_modal: String,
		nombre_modal: String,
	},

	methods: {
		CerrarModal(nombre_modal) {
			$("#" + nombre_modal).modal("hide");
		},
	},
};
</script>

<style lang="css"></style>
