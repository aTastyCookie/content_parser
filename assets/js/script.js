jQuery.noConflict()(function($){
	$(document).ready(function() {
		"use strict";
		$('textarea').focus(function(e) {
			e.target.select();
			$(e.target).one('mouseup', function(e) {
				e.preventDefault();
			});
		});
		if($("input").is(".switch")) {
				$(".switch").bootstrapSwitch();
		}
		$(".cheackall").click(function() {
            var checked_status = this.checked;
            var count_item = $(".download_count").attr('id').replace(/[^\d\.]/g, '');
            var i = 1;
			for (i = 1; i <= count_item; i++) {
                $('#tab' + i).each(function() {
                    this.checked = checked_status;
                });
            }
        });
		$("#phpbb_type").change(function(){
			if($("#phpbb_type").val() == 'topics'){
				$("#phpbb_topics").show();
				$("#phpbb_posts").hide();
			}else if($("#phpbb_type").val() == 'posts'){
				$("#phpbb_topics").hide();
				$("#phpbb_posts").show();
			}else {
				$("#phpbb_topics").hide();
				$("#phpbb_posts").hide();
			}
			
		});
		$("#smf_type").change(function(){
			if($("#smf_type").val() == 'topics'){
				$("#smf_topics").show();
				$("#smf_posts").hide();
			}else if($("#smf_type").val() == 'posts'){
				$("#smf_topics").hide();
				$("#smf_posts").show();
			}else {
				$("#smf_topics").hide();
				$("#smf_posts").hide();
			}
			
		});
		
		if($("div").is("#works")) {
			var url = 'http://php.foxsash.com/foxsash_works.php';
			$("#works").html('Loading...');
			$.get(
				url, "works",
				function(result,status) {
					$("#works").html(result);
					var $container = $('.foxsash_container');
				
					if ($container.length) {
						$container.waitForImages(function() {
				
							// initialize isotope
							$container.isotope({
								itemSelector: '.foxsash_item',
								layoutMode: 'masonry',
							});
				
							$('#filters a:first-child').addClass('filter_current');
							// filter items when filter link is clicked
							$("a", "#filters").on("click", function(e) {
								var selector = $(this).attr('data-filter');
								$container.isotope({
									filter: selector
								});
								$(this).removeClass('filter_button').addClass('filter_button filter_current').siblings().removeClass('filter_button filter_current').addClass('filter_button');
				
								return false;
							});
				
						}, null, true);
					}
				},
				"json"
			);
			return false;	
		}
	})
})