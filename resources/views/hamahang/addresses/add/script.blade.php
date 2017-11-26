<script>

    $(document).ready(function()
    {
        e_receiver_name = $('#receiver_name');
        e_receiver_family = $('#receiver_family');
        e_emergency_phone = $('#emergency_phone');
        e_land_phone_precode = $('#land_phone_precode');
        e_land_phone_number = $('#land_phone_number');
        e_province_id = $('#province_id');
        e_city_id = $('#city_id');
        e_address = $('#address');
        e_postal_code = $('#postal_code');
        e_default_address = $('#default_address');
        e_edit_id = $('#edit_id');

        $(document).on('change', '#province_id', function ()
        {
            e_city_id.empty();
            $.ajax
            ({
                type: 'get',
                url: '{!! route('calendar.provinces_and_cites.cities', ['pId' => '']) !!}/' + e_province_id.val(),
                data: {},
                dataType: 'json',
                success: function(data)
                {
                    $.each(data, function(k, v)
                    {
                        html_option = '<option value="' + v.id + '"' + ('{!! $city_id !!}' == v.id ? 'selected="selected"' : '') + '>' + v.name + '</option>';
                        e_city_id.append(html_option);
                    });
                },
            });
        });

        address_add = $('#address_add');
        e_target = $('.form_addresses').parent().parent();
        get_top = e_target.position().top;
        get_height = e_target.height();
        get_left = e_target.position().left;
        get_width = e_target.width();
        e_city_id.empty();
        e_province_id.change();
        e_target.animate({top: get_top - 50, height: get_height + 105, left: get_left + 300, width: get_width - 600, }, function()
        {
            $('.form_addresses').fadeIn();
        });
        $('.jsPanel-content').css({height: $('.jsPanel-content').height() + 105})
        $(document).on('click', '.jsglyph-close', function ()
        {
        });
    });

    function do_submit(thic)
    {
        var receiver_name = e_receiver_name.val();
        var receiver_family = e_receiver_family.val();
        var emergency_phone = e_emergency_phone.val();
        var land_phone_precode = e_land_phone_precode.val();
        var land_phone_number = e_land_phone_number.val();
        var province_id = e_province_id.val();
        var city_id = e_city_id.val();
        var address = e_address.val();
        var postal_code = e_postal_code.val();
        var default_address = e_default_address.val();
        var edit_id = e_edit_id.val();
        $(thic).attr('disabled', 'disabled');
        $.ajax
        ({
            type: 'POST',
            dataType: 'json',
            url: '{!! route('modals.addresses_add') !!}',
            data:
            {
                'receiver_name': receiver_name,
                'receiver_family': receiver_family,
                'province_id': province_id,
                'emergency_phone': emergency_phone,
                'land_phone_precode': land_phone_precode,
                'land_phone_number': land_phone_number,
                'city_id': city_id,
                'address': address,
                'postal_code': postal_code,
                'default_address': default_address,
                'edit_id': edit_id,
            },
            success: function(data)
            {
                if (data.success)
                {
                    $('.jsglyph-close').parent().parent().parent().parent().parent().fadeOut(function()
                    {
                        $('.jsglyph-close').click();
                        shipping_content();
                    });
                } else
                {
                    messageModal('fail', 'خطا', data.result);
                    $(thic).removeAttr('disabled');
                }
            },
        });
    }

</script>