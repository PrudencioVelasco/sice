 

<script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

<!-- bootstrap progress js -->
<script src="<?php echo base_url(); ?>/assets/js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/nicescroll/jquery.nicescroll.min.js"></script>


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
<script src="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.js"></script>
<!-- select2 -->
<script src="<?php echo base_url(); ?>/assets/js/select/select2.full.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/admin.js"></script>
<!-- PNotify -->
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/notify/pnotify.core.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/notify/pnotify.nonblock.js"></script>

<script>

    $(function() {
      var cnt = 4; //$("#custom_notifications ul.notifications li").length + 1;
      TabbedNotification = function(options) {
        var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
          "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

        if (document.getElementById('custom_notifications') == null) {
          alert('doesnt exists');
        } else {
          $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
          $('#custom_notifications #notif-group').append(message);
          cnt++;
          CustomTabs(options);
        }
      }

      CustomTabs = function(options) {
        $('.tabbed_notifications > div').hide();
        $('.tabbed_notifications > div:first-of-type').show();
        $('#custom_notifications').removeClass('dsp_none');
        $('.notifications a').click(function(e) {
          e.preventDefault();
          var $this = $(this),
            tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
            others = $this.closest('li').siblings().children('a'),
            target = $this.attr('href');
          others.removeClass('active');
          $this.addClass('active');
          $(tabbed_notifications).children('div').hide();
          $(target).show();
        });
      }

      CustomTabs();

      var tabid = idname = '';
      $(document).on('click', '.notification_close', function(e) {
        idname = $(this).parent().parent().attr("id");
        tabid = idname.substr(-2);
        $('#ntf' + tabid).remove();
        $('#ntlink' + tabid).parent().remove();
        $('.notifications a').first().addClass('active');
        $('#notif-group div').first().css('display', 'block');
      });
    })
  </script>
  <script type="text/javascript">
    var permanotice, tooltip, _alert;
    $(function() { 
<?php if(isset($mostrar) && !empty($mostrar) && $mostrar == true) {?>
      new PNotify({
        title: "Notificación",
        type: "info",
        text: "Usted tiene Alumnos reprobados pendientes por asignar.",
        nonblock: {
          nonblock: false
        },
       

        before_close: function(PNotify) {
          // You can access the notice's options with this. It is read only.
          //PNotify.options.text;

          // You can change the notice's options after the timer like this:
          PNotify.update({
            title: PNotify.options.title + " - Enjoy your Stay",
            before_close: null
          });
          PNotify.queueRemove();
          return false;
        }
      });
      <?php } ?>

    });
  </script>
<script>
    $(document).ready(function () {
        $(".select2_single").select2({
            placeholder: "Select a state",
            allowClear: true
        });

    });
</script>
<script>
    $(document).ready(function () {
        $(".select2_multiple").select2({
            maximumSelectionLength: 4,
            placeholder: "Seleccione multiples Materias",
            allowClear: true,
        });
    });
</script>


</body>

</html>