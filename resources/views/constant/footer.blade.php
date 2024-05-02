
        <!-- footer start-->
        <footer class="footer mb-0">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 footer-copyright">
                  <p class="mb-0">©{{__('constant.copyright')}} <script>document.write(/\d{4}/.exec(Date())[0])</script> {{__('constant.all_rights_reserved')}}.</p>
                </div>
                <div class="col-md-6">
                  <p class="pull-right mb-0">{{__('constant.quen_wishes_good_works')}} <i class="fa fa-heart font-primary"></i></p>
                </div>
              </div>
            </div>
          </footer>
        </div>
      </div>
      <!-- latest jquery-->
      <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
      <!-- feather icon js-->
      <script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
      <script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
      <!-- Sidebar jquery-->
      <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
      <script src="{{asset('assets/js/config.js')}}"></script>
      <!-- Bootstrap js-->
      <script src="{{asset('assets/js/bootstrap/popper.min.js')}}"></script>
      <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}}"></script>
      <!-- Plugins JS start-->
      <script src="{{asset('assets/js/prism/prism.min.js')}}"></script>
      <script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>
      <script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
      <script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
      <script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>
      <script src="{{asset('assets/js/custom-card/custom-card.js')}}"></script>
      <script src="{{asset('assets/js/chart-widget.js')}}"></script>
      <script src="{{asset('assets/js/height-equal.js')}}"></script>
      <script src="{{asset('assets/js/tooltip-init.js')}}"></script>
      <script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
      <script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
      <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
      <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
      <script src="{{asset('assets/js/form-validation-custom.js')}}"></script>
      <script src="{{asset('assets/js/bookmark/jquery.validate.min.js')}}"></script>
      <script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
      <script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
      <script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
      <script src="{{asset('assets/js/contacts/custom.js')}}"></script>
      <script src="{{asset('assets/js/cropperjs/cropper.min.js')}}"></script>
      <script src="{{asset('assets/js/editor/ckeditor/ckeditor.js')}}"></script>
      <script src="{{asset('assets/js/editor/ckeditor/adapters/jquery.js')}}"></script>
      <script src="{{asset('assets/js/email-app.js')}}"></script>
      <script src="{{asset('assets/js/scrollable/perfect-scrollbar.min.js')}}"></script>
      <script src="{{asset('assets/js/scrollable/scrollable-custom.js')}}"></script>
      <!-- Plugins JS Ends-->
      <!-- Datatable Plugins Start-->
      <!-- Datatable Plugins End-->
      <!-- Theme js-->
      <script src="{{asset('assets/custom.js')}}"></script>
      <script src="{{asset('assets/js/script.js')}}"></script>

      <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
      <script>
        $('#productTable').DataTable( {
            language: {
                processing:     "{{__('data_table.processing')}}",
                search:         "{{__('data_table.search')}}&nbsp;:",
                lengthMenu:     "{{__('data_table.length_menu')}}",
                info:           "{{__('data_table.info')}}",
                infoEmpty:      "{{__('data_table.info_empty')}}",
                infoFiltered:   "{{__('data_table.info_filtered')}}",infoPostFix:    "",
                loadingRecords: "{{__('data_table.loading_records')}}",
                zeroRecords:    "{{__('data_table.zero_records')}}",
                emptyTable:     "{{__('data_table.empty_table')}}",
                paginate: {
                    first:      "{{__('data_table.first')}}",
                    previous:   "{{__('data_table.previous')}}",
                    next:       "{{__('data_table.next')}}",
                    last:       "{{__('data_table.last')}}"
                },
                aria: {
                    sortAscending:  "{{__('data_table.sort_ascending')}}",
                    sortDescending: "{{__('data_table.sort_descending')}}"
                }
            }
        } );
      </script>
    </body>
  </html>
  <!-- Theme Preference -->
  @if (!Auth::user()->theme)
  <script>
    $(".customizer-color.dark li").ready(function () {
          $(".customizer-color.dark li").removeClass('active');
          $(this).addClass("active");
          $("body").attr("class", "dark-only");
          localStorage.setItem("dark", "dark-only");
      });
  </script>
  @endif
