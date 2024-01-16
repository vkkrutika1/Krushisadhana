<x-layout bodyClass="g-sidenav-show  bg-gray-200">
	<x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		<!-- Navbar -->
		<x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>
		<!-- End Navbar -->
		<div class="container-fluid py-4" id='dashboard'>
			@if ( session('status') )
			  <div class="alert alert-success" role="alert">
			    {{ session('status') }}
			  </div>
			@endif
			<div class="row">
				<div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
					<div class="card">
						<div class="card-header p-3 pt-2">
							<div
								class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10">add_circle</i>
							</div>
							<div class="text-end pt-1">
								<p class="text-sm mb-0 text-capitalize">Total Products</p>
								<h4 class="mb-0">{{ $productCount }}</h4>
							</div>
						</div>
						<hr class="dark horizontal my-0">
						<div class="card-footer p-3">
							<!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than
								lask week</p> -->
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
					<div class="card">
						<div class="card-header p-3 pt-2">
							<div
								class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10">label</i>
							</div>
							<div class="text-end pt-1">
								<p class="text-sm mb-0 text-capitalize">Total Labels</p>
								<h4 class="mb-0">{{ $totalCount }}</h4>
							</div>
						</div>
						<hr class="dark horizontal my-0">
						<div class="card-footer p-3">
							<!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than
								lask month</p> -->
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
					<div class="card">
						<div class="card-header p-3 pt-2">
							<div
								class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10">label</i>
							</div>
							<div class="text-end pt-1">
								<p class="text-sm mb-0 text-capitalize">Total Green Label</p>
								<h4 class="mb-0">{{ $green }}</h4>
							</div>
						</div>
						<hr class="dark horizontal my-0">
						<div class="card-footer p-3">
							<!-- <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than
								yesterday</p> -->
						</div>
					</div>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-xl-4 col-sm-6">
					<div class="card">
						<div class="card-header p-3 pt-2">
							<div
								class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10">label</i>
							</div>
							<div class="text-end pt-1">
								<p class="text-sm mb-0 text-capitalize">Total White Big Label</p>
								<h4 class="mb-0">{{ $white }}</h4>
							</div>
						</div>
						<hr class="dark horizontal my-0">
						<div class="card-footer p-3">
						<!-- 	<p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than
								yesterday</p> -->
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
					<div class="card">
						<div class="card-header p-3 pt-2">
							<div
								class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10">label</i>
							</div>
							<div class="text-end pt-1">
								<p class="text-sm mb-0 text-capitalize">Total White Medium Label</p>
								<h4 class="mb-0">{{ $medium }}</h4>
							</div>
						</div>
						<hr class="dark horizontal my-0">
						<div class="card-footer p-3">
							<!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than
								lask week</p> -->
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
					<div class="card">
						<div class="card-header p-3 pt-2">
							<div
								class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
								<i class="material-icons opacity-10">label</i>
							</div>
							<div class="text-end pt-1">
								<p class="text-sm mb-0 text-capitalize">Total Small Label </p>
								<h4 class="mb-0">{{ $small }}</h4>
							</div>
						</div>
						<hr class="dark horizontal my-0">
						<div class="card-footer p-3">
							<!-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than
								lask month</p> -->
						</div>
					</div>
				</div>
			</div>
			<x-footers.auth></x-footers.auth>
		</div>
	</main>
	<x-plugins></x-plugins>
</x-layout>
