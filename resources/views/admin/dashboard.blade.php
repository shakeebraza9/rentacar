@extends('admin.layout')

@section('css')
    <!-- ============================================================== -->
    <!-- Page CSS -->
    <!-- ============================================================== -->
    <style>
        @import url(https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700);
        .cmin-height {
        height: 105px; }
</style>
    
@endsection

@section('content')
    <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Dashboard 1</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-end">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb justify-content-end">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard 1</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->


                <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
                <div class="row g-0">
					<div class="col-lg-3 col-md-6">
						<div class="card border">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="d-flex no-block align-items-center">
											<div>
												<h3><i class="icon-screen-desktop"></i></h3>
												<p class="text-muted">MYNEW CLIENTS</p>
											</div>
											<div class="ms-auto">
												<h2 class="counter text-primary">23</h2>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="progress">
											<div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="card border">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="d-flex no-block align-items-center">
											<div>
												<h3><i class="icon-note"></i></h3>
												<p class="text-muted">NEW PROJECTS</p>
											</div>
											<div class="ms-auto">
												<h2 class="counter text-cyan">169</h2>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="progress">
											<div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="card border">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="d-flex no-block align-items-center">
											<div>
												<h3><i class="icon-doc"></i></h3>
												<p class="text-muted">NEW INVOICES</p>
											</div>
											<div class="ms-auto">
												<h2 class="counter text-purple">157</h2>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="progress">
											<div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="card border">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="d-flex no-block align-items-center">
											<div>
												<h3><i class="icon-bag"></i></h3>
												<p class="text-muted">All PROJECTS</p>
											</div>
											<div class="ms-auto">
												<h2 class="counter text-success">431</h2>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="progress">
											<div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
                <!-- ============================================================== -->
                <!-- End Info box -->
                <!-- ============================================================== -->



             



     
@endsection
@section('js')
<script>

    $(function () {
        "use strict";
        //This is for the Notification top right
        // $.toast({
        //         heading: 'Welcome to Elite admin'
        //         , text: 'Use the predefined ones, or specify a custom position object.'
        //         , position: 'top-right'
        //         , loaderBg: '#ff6849'
        //         , icon: 'info'
        //         , hideAfter: 3500
        //         , stack: 6
        //     })
            // Dashboard 1 Morris-chart
        Morris.Area({
            element: 'morris-area-chart'
            , data: [{
                    period: '2010'
                    , iphone: 50
                    , ipad: 80
                    , itouch: 20
            }, {
                    period: '2011'
                    , iphone: 130
                    , ipad: 100
                    , itouch: 80
            }, {
                    period: '2012'
                    , iphone: 80
                    , ipad: 60
                    , itouch: 70
            }, {
                    period: '2013'
                    , iphone: 70
                    , ipad: 200
                    , itouch: 140
            }, {
                    period: '2014'
                    , iphone: 180
                    , ipad: 150
                    , itouch: 140
            }, {
                    period: '2015'
                    , iphone: 105
                    , ipad: 100
                    , itouch: 80
            }
                , {
                    period: '2016'
                    , iphone: 250
                    , ipad: 150
                    , itouch: 200
            }]
            , xkey: 'period'
            , ykeys: ['iphone', 'ipad', 'itouch']
            , labels: ['iPhone', 'iPad', 'iPod Touch']
            , pointSize: 3
            , fillOpacity: 0
            , pointStrokeColors:['#888', '#e20b0b', '#f1c411']
            , behaveLikeLine: true
            , gridLineColor: '#e0e0e0'
            , lineWidth: 3
            , hideHover: 'auto'
            , lineColors: ['#888', '#e20b0b', '#f1c411']
            , resize: true
        });
        Morris.Area({
            element: 'morris-area-chart2'
            , data: [{
                    period: '2010'
                    , SiteA: 0
                    , SiteB: 0
            , }, {
                    period: '2011'
                    , SiteA: 130
                    , SiteB: 100
            , }, {
                    period: '2012'
                    , SiteA: 80
                    , SiteB: 60
            , }, {
                    period: '2013'
                    , SiteA: 70
                    , SiteB: 200
            , }, {
                    period: '2014'
                    , SiteA: 180
                    , SiteB: 150
            , }, {
                    period: '2015'
                    , SiteA: 105
                    , SiteB: 90
            , }
                , {
                    period: '2016'
                    , SiteA: 250
                    , SiteB: 150
            , }]
            , xkey: 'period'
            , ykeys: ['SiteA', 'SiteB']
            , labels: ['Site A', 'Site B']
            , pointSize: 0
            , fillOpacity: 0.4
            , pointStrokeColors: ['#b4becb', '#01c0c8']
            , behaveLikeLine: true
            , gridLineColor: '#e0e0e0'
            , lineWidth: 0
            , smooth: false
            , hideHover: 'auto'
            , lineColors: ['#b4becb', '#01c0c8']
            , resize: true
        });
    });    
        // sparkline
        var sparklineLogin = function() { 
            $('#sales1').sparkline([20, 40, 30], {
                type: 'pie',
                height: '90',
                resize: true,
                sliceColors: ['#01c0c8', '#7d5ab6', '#ffffff']
            });
            $('#sparkline2dash').sparkline([6, 10, 9, 11, 9, 10, 12], {
                type: 'bar',
                height: '154',
                barWidth: '4',
                resize: true,
                barSpacing: '10',
                barColor: '#25a6f7'
            });
        };    

        var sparkResize;
        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineLogin, 500);
        });
        sparklineLogin();


</script>
@endsection