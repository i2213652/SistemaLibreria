<template>
	<div class="card-header d-flex align-items-center justify-content-between">
		<strong>{{ title }}</strong>
		<Link :href="$route('home', 'ACEPTADO')" style="float: right !important">
			<button type="button" class="btn btn-purple" style="border-radius: 50%">
				<span class="icon">
					<i class="bi bi-x-lg" style="font-weight: bolder"></i>
				</span>
			</button>
		</Link>
	</div>
</template>

<script>
export default {
	props: {
		title: String,
	},
};
</script>

<style lang="css">
</style>
