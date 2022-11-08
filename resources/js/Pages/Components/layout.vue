<template>
	<!-- <div id="app"> -->
	<div class="layout-horizontal" style="height: 100% !important">
		<header class="mb-4">
			<div class="header-top">
				<div class="container">
					<div class="logo bolder">
						<Link :href="$route('home')">LIBRERÍA COQUITO S.A. </Link>
					</div>
					<div class="header-top-right">
						<!-- Burger button responsive -->
						<a href="#" class="burger-btn d-block d-xl-none">
							<i class="bi bi-justify fs-3"></i>
						</a>
					</div>
				</div>
			</div>
			<nav class="main-navbar">
				<div class="container">
					<ul>
						<li class="menu-item has-sub">
							<a href="#" class="menu-link">
								<i class="bi bi-shop"></i>
								<span>Inventario</span>
							</a>
							<div class="submenu">
								<!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
								<div class="submenu-group-wrapper">
									<ul class="submenu-group">
										<li class="submenu-item">
											<Link class="submenu-link" :href="$route('inv.productos')"
												>Productos
											</Link>
										</li>
									</ul>
								</div>
							</div>
						</li>

						<li class="menu-item has-sub">
							<a href="#" class="menu-link">
								<i class="bi bi-sliders"></i>
								<span>Mantenimiento</span>
							</a>
							<div class="submenu">
								<!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
								<div class="submenu-group-wrapper">
									<ul class="submenu-group">
										<li class="submenu-item">
											<Link
												class="submenu-link"
												:href="$route('man.inv.categorias')"
												>Categorías</Link
											>
										</li>

										<li class="submenu-item">
											<Link
												class="submenu-link"
												:href="$route('man.inv.marcas')"
												>Marcas</Link
											>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<div class="content-wrapper container" id="content">
			<slot name="component-view"></slot>
		</div>
	</div>
	<!-- </div> -->
</template>

<script>
export default {
	components: {},

	mounted() {
		let url = "/js/pages/horizontal-layout.js";
		if (document.querySelectorAll(`script[src="${url}"]`).length == 0) {
			let recaptchaScript = document.createElement("script");
			recaptchaScript.setAttribute("src", url);
			document.body.appendChild(recaptchaScript);
		}

		// Responsive burger btn onclick
		document.querySelector(".burger-btn").addEventListener("click", (e) => {
			e.preventDefault();
			let navbar = document.querySelector(".main-navbar");

			slideToggle(navbar, 300);
		});

		this.VerificarResponsive();

		// document.body.style.paddingTop = "20px";
		document.body.style.backgroundImage =
			"url('/images/general/main_background.jpg')";

		document.body.style.backgroundPosition = "center center";
		document.body.style.backgroundRepeat = "repeat-yt";
		document.body.style.backgroundAttachment = "fixed";
		document.body.style.backgroundSize = "cover";

		document.addEventListener("contextmenu", (event) => event.preventDefault());
	},

	methods: {
		VerificarResponsive() {
			if (window.innerWidth < 1200) {
				let menuItems = document.querySelectorAll(".menu-item.has-sub");

				menuItems.forEach((menuItem) => {
					menuItem
						.querySelector(".menu-link")
						.addEventListener("click", (e) => {
							e.preventDefault();
							let submenu = menuItem.querySelector(".submenu");
							submenu.classList.toggle("active");
						});
				});

				// Three level menu event listener
				let submenuItems = document.querySelectorAll(".submenu-item.has-sub");

				submenuItems.forEach((submenuItem) => {
					submenuItem
						.querySelector(".submenu-link")
						.addEventListener("click", (e) => {
							e.preventDefault();
							submenuItem
								.querySelector(".subsubmenu")
								.classList.toggle("active");
						});
				});
			}
			if (window.innerWidth > 1200) {
				document.querySelector(".main-navbar").style.display = "";
			}
		},
	},
};
</script>

<style >
</style>
