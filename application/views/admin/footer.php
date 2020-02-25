 

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