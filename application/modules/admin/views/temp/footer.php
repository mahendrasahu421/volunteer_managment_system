		<!-- FOOTER -->
		<footer class="footer">
			<div class="container">
				<div class="row align-items-center flex-row-reverse">
					<div class="col-md-12 col-sm-12 text-center">
						Copyright © <span id="year"></span> <a href="javascript:void(0);">CRY</a>. Designed with by <a href="https://www.neuralinfo.in/" target="_blank"> Neural info solutions </a>
					</div>
				</div>
			</div>
		</footer>
		<!-- FOOTER END -->
		</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		<script>
			function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
				//If JSONData is not an object then JSON.parse will parse the JSON string in an Object
				var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
				var k = 1;
				var CSV = '';
				//Set Report title in first row or line

				//CSV += ReportTitle + '\r\n\n';

				//This condition will generate the Label/Header
				if (ShowLabel) {
					var row = "Sr.No,";

					//This loop will extract the label from 1st index of on array
					for (var index in arrData[0]) {

						//Now convert each value to string and comma-seprated
						row += index + ',';
					}

					row = row.slice(0, -1);

					//append Label row with line break
					CSV += row + '\r\n';
				}

				//1st loop is to extract each row
				for (var i = 0; i < arrData.length; i++) {
					var row = k + ",";

					//2nd loop will extract each column and convert it in string comma-seprated
					for (var index in arrData[i]) {
						row += '"' + arrData[i][index] + '",';
					}

					row.slice(0, row.length - 1);

					//add a line break after each row
					CSV += row + '\r\n';
					k++
				}

				if (CSV == '') {
					alert("Invalid data");
					return;
				}

				//Generate a file name
				var fileName = "";
				//this will remove the blank-spaces from the title and replace it with an underscore
				fileName += ReportTitle.replace(/ /g, "_");

				//Initialize file format you want csv or xls
				var uri = 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURI(CSV);

				// Now the little tricky part.
				// you can use either>> window.open(uri);
				// but this will not work in some browsers
				// or you will not get the correct file extension    

				//this trick will generate a temp <a /> tag
				var link = document.createElement("a");
				link.href = uri;

				//set the visibility hidden so it will not effect on your web-layout
				link.style = "visibility:hidden";
				link.download = fileName + "_" + new Date() + ".csv";

				//this part will append the anchor tag and remove it after automatic click
				document.body.appendChild(link);
				link.click();
				document.body.removeChild(link);
			}
		</script>

		<script>
			$('#exampleModal').on('show.bs.modal', function(event) {
				// Button that triggered the modal
				var li = $(event.relatedTarget)
				// Extract info from data attributes 
				var recipient = li.data('whatever')
				// Updating the modal content using 
				// jQuery query selectors
				var modal = $(this)
				modal.find('.modal-title')
					.text('New message to ' + recipient)

				modal.find('.modal-body p')
					.text('Welcome to ' + recipient)
			});
		</script>
		<script>
			// Example starter JavaScript for disabling form submissions if there are invalid fields
			(function() {
				'use strict'

				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.querySelectorAll('.needs-validation')

				// Loop over them and prevent submission
				Array.prototype.slice.call(forms)
					.forEach(function(form) {
						form.addEventListener('submit', function(event) {
							if (!form.checkValidity()) {
								event.preventDefault()
								event.stopPropagation()
							}

							form.classList.add('was-validated')
						}, false)
					})
			})()
		</script>

		<!-- <script src="<?php echo base_url() ?>admin/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
		</script> -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
		</script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
		</script>
		<!-- JQUERY JS -->

		<!-- BOOTSTRAP JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/jquery.sparkline.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/circle-progress.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/charts-c3/d3.v5.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/charts-c3/c3-chart.js"></script>

		<!-- INPUT MASK JS-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/input-mask/jquery.mask.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/chart/Chart.bundle.js"></script>

		<!-- SIDE-MENU JS-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/sidemenu/sidemenu.js"></script>

		<!-- Sticky js -->
		<script src="<?php echo base_url('admin/'); ?>assets/js/sticky.js"></script>

		<!-- SIDEBAR JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/sidebar/sidebar.js"></script>

		<!-- Perfect SCROLLBAR JS-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/p-scroll/perfect-scrollbar.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/p-scroll/pscroll.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/p-scroll/pscroll-1.js"></script>

		<!-- FILE UPLOADES JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/fileuploads/js/fileupload.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/fileuploads/js/file-upload.js"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!--<script>
			$(document).ready(function() {
				$('#example').DataTable({
					dom: 'Bfrtip',
					buttons: [
						'copy', 'csv', 'excel', 'pdf', 'print'
					]
				});
			});
		</script>-->


		<script>
			$(document).ready(function() {
				$('#example').DataTable({
					order: [
						//  [3, 'desc']
					],
					buttons: [
						'copy', 'csv', 'excel', 'pdf', 'print'
					]
				});
			});
		</script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/jquery-3.5.1.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/jszip.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/pdfmake.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/vfs_fonts.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/buttons.print.min.js"></script>

		<!-- INTERNAL File-Uploads Js-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.fileupload.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/fancy-uploader.js"></script>

		<!-- SELECT2 JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/select2/select2.full.min.js"></script>

		<!-- BOOTSTRAP-DATERANGEPICKER JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

		<!-- INTERNAL Bootstrap-Datepicker js-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

		<!-- INTERNAL Sumoselect js-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/sumoselect/jquery.sumoselect.js"></script>

		<!-- TIMEPICKER JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/time-picker/jquery.timepicker.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/time-picker/toggles.min.js"></script>

		<!-- INTERNAL intlTelInput js-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/intl-tel-input-master/intlTelInput.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/intl-tel-input-master/country-select.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/intl-tel-input-master/utils.js"></script>

		<!-- INTERNAL jquery transfer js-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/jQuerytransfer/jquery.transfer.js"></script>

		<!-- INTERNAL multi js-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/multi/multi.min.js"></script>

		<!-- DATEPICKER JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/date-picker/date-picker.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/date-picker/jquery-ui.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/input-mask/jquery.maskedinput.js"></script>

		<!-- MULTI SELECT JS-->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/multipleselect/multiple-select.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/multipleselect/multi-select.js"></script>

		<!-- FORMELEMENTS JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/js/formelementadvnced.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/form-elements.js"></script>

		<!-- Color Theme js -->
		<script src="<?php echo base_url('admin/'); ?>assets/js/themeColors.js"></script>

		<!-- CUSTOM JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/js/custom.js"></script>

		<!----------matching editor js------------>


		<!-- WYSIWYG Editor JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/wysiwyag/jquery.richtext.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/wysiwyag/wysiwyag.js"></script>

		<!-- FORMEDITOR JS -->
		<script src="<?php echo base_url('admin/'); ?>assets/plugins/quill/quill.min.js"></script>
		<script src="<?php echo base_url('admin/'); ?>assets/js/form-editor2.js"></script>
		</body>

		</html>