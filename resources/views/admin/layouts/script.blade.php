{{-- @vite(['resources/assets/admin/js/app-script.js']) --}}

<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
{{-- <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script> --}}
{{-- <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script> --}}
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/js/pages/data-tables-custom.js') }}"></script>

<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>


<!-- Peity chart-->
<script src="{{ asset('assets/libs/peity/jquery.peity.min.js') }}"></script>

<!--C3 Chart-->
<script src="{{ asset('assets/libs/d3/d3.min.js') }}"></script>
<script src="{{ asset('assets/libs/c3/c3.min.js') }}"></script>

<script src="{{ asset('assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>

<script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
<script src="{{ asset('assets/js/pages/data-tables-custom.js') }}"></script>

<script src="{{ asset('assets/js/pages/data-tables-custom.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/app-custom.js') }}"></script>


@yield('script')
