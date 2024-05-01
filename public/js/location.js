$(document).ready(function () {
    const provinceEl = 'province_id';
    const provinceSpinner = 'province_spinner';
    const provinceSelect = 'province_select';

    const cityEl = 'city_id';
    const citySpinner = 'city_spinner';
    const citySelect = 'city_select';

    const countryEl = 'country_id';
    let province = $('#' + provinceEl);
    let city =  $('#' + cityEl);
    let cityId = $('#' + cityEl).val();

    $(document).on('change', '#' + countryEl, function () {
        let value = $(this).val();
        let provinceId = province.val();

        if (value.length == 0) {
            resetField(provinceEl);
            resetField(cityEl);
            return;
        }

        $.ajax({
            url: '/provinces',
            data: {
                country_id: value
            },
            dataType: 'JSON',
            beforeSend: function () {
                showSpinner(provinceEl, true, provinceSpinner, provinceSelect);
            },
            success: function (data) {
                showSpinner(provinceEl, false, provinceSpinner, provinceSelect);

                resetField(provinceEl);
                resetField(cityEl);

                if (data.length) {
                    province.select2('destroy')
                        .empty()
                        .select2({
                            data: data
                            ,theme: 'bootstrap'
                        })
                        .attr('disabled', false);

                    if (provinceId != null
                        && provinceId.length
                    ) {
                        province.val(provinceId).trigger('change');
                    }
                }
            },
            error: function () {
                showSpinner(provinceEl, false, provinceSpinner, provinceSelect);
                resetField(provinceEl);
                resetField(cityEl);
            }
        });
    });

    let countryId = $(`#${countryEl}`).val();
    if (countryId != null
        && countryId.length
    ) {
        $(`#${countryEl}`).trigger('change');
    }

    $(document).on('change', '#' + provinceEl, function (e) {
        let value = $(this).val();

        if (value.length == 0) {
            resetField(cityEl);
            return;
        }

        $.ajax({
            url: '/cities',
            data: {
                province_id: value
            },
            dataType: 'JSON',
            beforeSend: function () {
                showSpinner(cityEl, true, citySpinner, citySelect);
            },
            success: function (data) {
                showSpinner(cityEl, false, citySpinner, citySelect);
                resetField(cityEl);

                if (data.length) {
                    city.select2('destroy')
                        .empty()
                        .select2({
                            data: data
                            ,theme: 'bootstrap'
                        })
                        .attr('disabled', false);

                    if (cityId != null
                        && cityId.length
                    ) {
                        city.val(cityId).trigger('change');
                    }
                }
            },
            error: function () {
                showSpinner(cityEl, false, citySpinner, citySelect);
                resetField(cityEl);
            }
        });
    });
});