<footer id="footer" class="midnight-blue">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<p align="center">SIPEPENG | Sistem Informasi Pemetaan Pembangunan <br />
					Proyek Perubahan Diklatpim IV - DEVI JANUAR HADI, S.Si, M.Si  <br /> 
				<small><i>Developed by Ratih Pujihati dan  Riza Fauzi Rahman</i> </small> </p>
			</div>                
		</div>
	</div>
</footer><!--/#footer-->

<script src="<?php echo base_url() ?>assets/public/js/jquery.js"></script>
<script src="<?php echo base_url() ?>assets/public/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/public/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo base_url() ?>assets/public/js/jquery.isotope.min.js"></script>
<script src="<?php echo base_url() ?>assets/public/js/main.js"></script>
<script src="<?php echo base_url() ?>assets/public/js/wow.min.js"></script>


<script src="<?php echo base_url(); ?>assets/admin/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/assets/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/admin/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>


<script>
	$(document).ready(function() {
		$(window).scroll(function() {
			if ($(document).scrollTop() > 50) {
				$('nav').addClass('shrink');
				} else {
				$('nav').removeClass('shrink');
			}
		});
	});
	
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#example').dataTable( {
            "aaSorting": [[ 0, "asc" ]]
		} );
		<!-- Menu Toggle Script -->
		$("#menu-toggle").click(function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});
	} );
	
</script>


</body>
</html>

