 

  <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="<?php echo base_url(); ?>/assets/js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="<?php echo base_url(); ?>/assets/js/icheck/icheck.min.js"></script>

  <script src="<?php echo base_url(); ?>/assets/js/custom.js"></script>
  <!-- pace -->
  <script src="<?php echo base_url(); ?>/assets/js/pace/pace.min.js"></script>

    <!-- image cropping -->
  <script src="<?php echo base_url(); ?>/assets/js/cropping/cropper.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/cropping/main.js"></script>
  
  <!-- Datatables-->
<script src="<?php echo base_url(); ?>/assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/responsive.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.scroller.min.js"></script>

    <!-- select2 -->
  <script src="<?php echo base_url(); ?>/assets/js/select/select2.full.js"></script>

   <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Select a state",
        allowClear: true
      }); 
    });
  </script>
    <script>
    $(document).ready(function() { 
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Seleccione multiples Materias",
        allowClear: true
      });
    });
  </script>

</body>

</html>