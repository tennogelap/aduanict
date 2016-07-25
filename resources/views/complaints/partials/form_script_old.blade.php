<script type="text/javascript">
    $( document ).ready(function() {

        //update masa
        var servertime = parseFloat( $("#servertime").val() ) * 1000;
        $.clock.locale.pt ={"weekdays":["Isnin","Selasa", "Rabu","Khamis","Jumaat","Sabtu", "Ahad"],"months":["Januari","Februari","Mac","April", "Mei","Jun","Julai","Ogos","September","Oktober","November", "Disember"]};
        $("#clock").clock({
            "timestamp":servertime,
            "calendar":"true",
            "langSet":"pt"
        });

        //bagi_pihak on validation error
        if ($('#bagi_pihak').prop("checked")){
            $('#pilih_bagi_pihak').show();
        }
        else
        {
            $('#pilih_bagi_pihak').hide();
        }

        //
        var Vcomplain_category_id = $("#complain_category_id").val();
        console.log(Vcomplain_category_id);
        show_hide_by_category(Vcomplain_category_id);

        //when user click bagi pihak
        $('#bagi_pihak').change(function(){
            //var bagi_pihak = $(this).val();
            //console.log(bagi_pihak);
            if ($(this).prop("checked")){
                $('#pilih_bagi_pihak').fadeIn(200);
            }
            else
            {
//                    $("#pilih_bagi_pihak").trigger("chosen:updated");
                $('#pilih_bagi_pihak').fadeOut(200);
                $('#user_emp_id').val('');
            }
        });

        $( "#complain_category_id" ).change(function() {
            var complain_category_id = $(this).val();
            show_hide_by_category(complain_category_id[0]);
            $("#complain_source_id").val('');
            $("#complain_source_id").trigger("chosen:updated");
        });

        $( "#branch_id" ).change(function() {
            var branch_id = $(this).val();
            get_locations_by_branch(branch_id);
        });

        $( "#lokasi_id" ).change(function() {
            var lokasi_id = $(this).val();
            get_assets_by_locations(lokasi_id);
        });

        //function untuk show hide by category
        function show_hide_by_category(complain_category_id)
        {
            //if no category selected, just exit the function
            if(!complain_category_id)
            {
                return;
            }

            var exp_complain_category_id = complain_category_id.split('-');
            complain_category_id = exp_complain_category_id[0];

//                console.log(complain_category_id);
            if(complain_category_id==5||complain_category_id==6)
            {
                $('.hide_by_category').hide();
            }
            else
            {
                $('.hide_by_category').show();
            }
            //when validation error after processing form, reinitialize
            //start code

            //end code
        }

        //function untuk panggilan location ikut branch ajax
        function get_locations_by_branch(branch_id)
        {
            $.ajax
            ({
                type: "GET",
                url: base_url + '/complain/locations',
                dataType: "json",
                data:
                {
                    branch_id : branch_id
                },
                beforeSend: function()
                {
                    //////////////////////////////
                },
                success: function (location_data)
                {
                    $("#lokasi_id").empty();

                    //create a new dropdown option using the data provided by json object

                    $.each(location_data, function(key, value) {
                        $("#lokasi_id").append("<option value='"+ key +"'>" + value + "</option>");
                    });
                    $("#lokasi_id").val('');
                    $("#lokasi_id").trigger("chosen:updated");
                }
            });

        }
        //function untuk panggilan aset ikut location ajax
        function get_assets_by_locations(location_id)
        {
            $.ajax
            ({
                type: "GET",
                url: base_url + '/complain/assets',
                dataType: "json",
                data:
                {
                    lokasi_id : location_id
                },
                beforeSend: function()
                {
                    //////////////////////////////
                },
                success: function (assets_data)
                {
                    $("#ict_no").empty();

                    //create a new dropdown option using the data provided by json object

                    $.each(assets_data, function(key, value) {
                        $("#ict_no").append("<option value='"+ key +"'>" + value + "</option>");
                    });
                    $("#ict_no").val('');
                    $("#ict_no").trigger("chosen:updated");
                }
            });

        }
    });
</script>