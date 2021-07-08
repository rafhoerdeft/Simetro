    <!-- ============================================================== -->

    <!-- footer -->

    <!-- ============================================================== -->

    <footer class="footer d-none d-sm-none d-md-block"> © <?= date('Y') ?> SiMetro for Direktorat Metrologi Kab. Magelang by DISKOMINFO Kab. Magelang </footer>

    <footer class="footer d-block d-sm-block d-md-none"> © 2019 SiMetro by DISKOMINFO</footer>





    <!-- ============================================================== -->

    <!-- End footer -->

    <!-- ============================================================== -->

    </div>

    <!-- ============================================================== -->

    <!-- End Page wrapper  -->

    <!-- ============================================================== -->





    </div>

    <!-- ============================================================== -->

    <!-- End Wrapper -->

    <!-- ============================================================== -->

    <!-- ============================================================== -->

    <!-- All Jquery -->

    <!-- ============================================================== -->



    <?php foreach ($foot as $val) { ?>
        <script src="<?= base_url() . $val ?>"></script>
    <?php } ?>



    <?php
    if (isset($js_link)) {
        foreach ($js_link as $js) {
    ?>

            <script src="<?= $js ?>"></script>

    <?php }
    } ?>





    <?php

    if (isset($script)) {
        foreach ($script as $scr) {
    ?>



            <script type="text/javascript">
                <?= $scr ?>
            </script>



    <?php }
    } ?>



    <!-- <script>

        ! function(window, document, $) {

            "use strict";

            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(), $(".skin-square input").iCheck({

                checkboxClass: "icheckbox_square-green",

                radioClass: "iradio_square-green"

            }), $(".touchspin").TouchSpin(), $(".switchBootstrap").bootstrapSwitch();

        }(window, document, jQuery);

    </script> -->



    <script type="text/javascript">
        function inputAngka(evt) {

            var charCode = (evt.which) ? evt.which : event.keyCode

            // alert(charCode);

            if (charCode > 31 && (charCode < 46 || charCode > 57))



                return false;

            return true;

        }
    </script>



    <!-- <script type="text/javascript">

        lightbox.option({

            'albumLabel':   "picture %1 of %2",

            'fadeDuration': 300,

            'resizeDuration': 150,

            'wrapAround': true

        })

    </script> -->



    <script type="text/javascript">
        // $(document).ready(function(){



        // $('.autocomplete').autocomplete({

        //     source: "<?//= base_url().'Admin/getDataUser'?>",



        //     select: function (event, ui) {

        //         $('#id_user').val(ui.item.id); 

        //     }

        // });



        // });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#altz').fadeTo(3000, 500).slideUp(500);
        });
    </script>


    <!-- <script type="text/javascript">

        $(document).ready(function(){



             $(document).on('keydown', '.username', function() {

             

              var id = this.id;

              var splitid = id.split('_');

              var index = splitid[1];



              // Initialize jQuery UI autocomplete

              $( '#'+id ).autocomplete({

               source: function( request, response ) {

                $.ajax({

                 url: "getDetails.php",

                 type: 'post',

                 dataType: "json",

                 data: {

                  search: request.term,request:1

                 },

                 success: function( data ) {

                  response( data );

                 }

                });

               },

               select: function (event, ui) {

                $(this).val(ui.item.label); // display the selected text

                var userid = ui.item.value; // selected value



                // AJAX

                $.ajax({

                 url: 'getDetails.php',

                 type: 'post',

                 data: {userid:userid,request:2},

                 dataType: 'json',

                 success:function(response){

             

                  var len = response.length;



                  if(len > 0){

                   var id = response[0]['id'];

                   var name = response[0]['name'];

                   var email = response[0]['email'];

                   var age = response[0]['age'];

                   var salary = response[0]['salary'];



                   // Set value to textboxes

                   document.getElementById('name_'+index).value = name;

                   document.getElementById('age_'+index).value = age;

                   document.getElementById('email_'+index).value = email;

                   document.getElementById('salary_'+index).value = salary;

             

                  }

             

                 }

                });



                return false;

               }

              });

             });

             

             // Add more

             $('#addmore').click(function(){



              // Get last id 

              var lastname_id = $('.tr_input input[type=text]:nth-child(1)').last().attr('id');

              var split_id = lastname_id.split('_');



              // New index

              var index = Number(split_id[1]) + 1;



              // Create row with input elements

              var html = "<tr class='tr_input'><td><input type='text' class='username' id='username_"+index+"' placeholder='Enter username'></td><td><input type='text' class='name' id='name_"+index+"' ></td><td><input type='text' class='age' id='age_"+index+"' ></td><td><input type='text' class='email' id='email_"+index+"' ></td><td><input type='text' class='salary' id='salary_"+index+"' ></td></tr>";



              // Append data

              $('tbody').append(html);

             

             });

            });

    </script> -->



    </body>



    </html>