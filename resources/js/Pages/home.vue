<template>
	<layout ref="layout">
		<div slot="component-view"></div>
	</layout>
</template>

<script>
import layout from "./Components/layout";
export default {
	components: { layout },
	props: { estado: String },

	mounted() {},
};
</script>

<style>
</style>
