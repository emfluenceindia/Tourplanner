        <?php wp_footer(); ?>
        <div class="container-fluid">
            <div class="row margin-top-20 site-footer pad-20 footer-container roboto">
                <div class="col-md-3"></div>
                <div class="col-md-7 text-small text-center">
                    <p><span class="text-white">&copy;</span> <a href="/" class="baloo">Dream Destinations</a> 2017-2020. All rights reserved.</p>
                    <hr class="footer-hr" />
                    <p>All contents of this site are under copyright. Any reproduction or such is strictly prohibited. If any individual or institution or company is found reproducing any content of the site would come under Cyber Piracy Act 2006.</p>
                </div>
                <div class="col-md-2"></div>
                <div class="clearfix"></div>
            </div>
        </div>
        <script type="text/javascript">
            //$(function() {
                //$('.grid-box').matchHeight();
                //$(".grid-box").equalHeights();
            //});
            $( document ).ready(function() {
                var heights = $(".grid-box").map(function() {
                   return $(this).height();
                }).get(),

                maxHeight = Math.max.apply(null, heights);

                $(".grid-box").each(function(){
                    $(this).height(maxHeight);
                });

                $("img").each(function(){
                    $(this).removeAttr('width');
                    $(this).removeAttr('height');
                });

                $(".storyline-anchor").click(function() {
                    scrollToAnchor();
                });
            });

            function scrollToAnchor(){
                var aTag = $(".story-line");
                $('html,body').animate({scrollTop: aTag.offset().top},'slow');
            }

            function enlargeImage(obj) {
                var thisImage = $(obj).find('img').attr('src');
                $('.main-post-image').find('img').attr('src', thisImage);
            }

            /*$('a[href*=\\#]').on('click', function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
            });*/
        </script>
    </body>
</html>