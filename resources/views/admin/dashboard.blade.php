@extends('template/dashboardAdmin')

@section('title', 'Dashboard')
@section('section')

                     <div class="row column1">
                        <div class="col-md-6 col-lg-6">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-group yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                 <p class="head_couter" style="color:black; font-size:11;">Total users</p>                                    
                                 <p class="total_no">{{ $totalStaff }}</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-group green_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                 <p class="head_couter" style="color:black; font-size:11;">HR users</p>                                    
                                 <p class="total_no">{{ $totalHR }}</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        
                     </div>
                     
                     
                     <div class="col-lg-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Roles of staff</h2>
                                 </div>
                              </div>
                              <div class="map_section padding_infor_info"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                 <canvas id="pie_chart" width="1300" height="650" style="display: block; height: 325px; width: 650px;" class="chartjs-render-monitor"></canvas>
                              </div>
                           </div>
                        </div>   
                        
                        <!-- jQuery -->
<script src="{{ asset('template/js/jquery.min.js') }}"></script>
<script src="{{ asset('template/js/popper.min.js') }}"></script>
<script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
<!-- chart js -->
<script src="{{ asset('template/js/Chart.min.js') }}"></script>
<script src="{{ asset('template/js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('template/js/utils.js') }}"></script>
<script src="{{ asset('template/js/analyser.js') }}"></script>
<!-- wow animation -->
<script src="{{ asset('template/js/animate.js') }}"></script>
<!-- select country -->
<script src="{{ asset('template/js/bootstrap-select.js') }}"></script>
<!-- owl carousel -->
<script src="{{ asset('template/js/owl.carousel.js') }}"></script>
<!-- nice scrollbar -->
<script src="{{ asset('template/js/perfect-scrollbar.min.js') }}"></script>
<!-- sidebar -->
<script>
   var ps = new PerfectScrollbar('#sidebar');
</script>
<!-- custom js -->
<script src="{{ asset('template/js/custom.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById("pie_chart").getContext("2d");

   const labels = {!! json_encode($roleLabels) !!}.map(role =>
      role === 'CEO' ? 'Head of Department' : role
   );
    const data = {!! json_encode($roleCounts) !!};

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#8AFFC1", "#A28DFF", "#FFA685"],
                hoverBackgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#8AFFC1", "#A28DFF", "#FFA685"]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
});
</script>
@endsection