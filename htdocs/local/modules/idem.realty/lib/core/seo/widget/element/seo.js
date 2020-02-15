$(function () {
  function showActialFields($departament) {
    switch ($departament) {
      case '1':
        $("select[name='FIELDS[object_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[built_status]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[parking]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[deal_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[finish_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[country_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[foreign_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[commerc_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[built_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[water]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[forest]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[transport_ring]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[district]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[country]']").parent('td').parent('tr').hide();
        break;
      case '2': //коммерция
        $("select[name='FIELDS[commerc_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[built_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[built_status]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[transport_ring]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[district]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[deal_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[finish_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[country_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[foreign_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[object_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[parking]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[water]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[forest]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[country]']").parent('td').parent('tr').hide();
        break;
      case '3': //загородная
        $("select[name='FIELDS[country_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[forest]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[water]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[deal_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[finish_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[object_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[foreign_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[commerc_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[built_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[built_status]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[parking]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[transport_ring]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[district]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[country]']").parent('td').parent('tr').hide();
        break;
      case '5': //зарубежка
        $("select[name='FIELDS[foreign_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[country]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[deal_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[finish_type]']").parent('td').parent('tr').show();
        $("select[name='FIELDS[country_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[object_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[commerc_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[built_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[built_status]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[parking]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[water]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[forest]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[transport_ring]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[district]']").parent('td').parent('tr').hide();
        break;
      default:
        $("select[name='FIELDS[foreign_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[country]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[deal_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[finish_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[country_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[object_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[commerc_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[built_type]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[built_status]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[parking]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[water]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[forest]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[transport_ring]']").parent('td').parent('tr').hide();
        $("select[name='FIELDS[district]']").parent('td').parent('tr').hide();
        break;
    }
  }

  function createUrl() {
    let $selects = [];
    let $data = {};
    let $baseLink = $("input[name='FIELDS[base_link]']").val();
    let $seoLink = "";
    let $seoLinkSection = "";
    $('select').each(function (select, val) {
      if ($(this).val().length) {
        let name = $(this).attr('name').replace(/\bFIELDS\b/, "");
        name = name.replace(/\[/, "");
        name = name.replace(/\]/, "");
        let tempSelectVal = $(this).find('option:selected').text().split('|');
        if (name != 'department') {
          $selects.push(name + '=' + tempSelectVal[1]);
          $data[name] = tempSelectVal[1];
        } else {
          $data[name] = tempSelectVal[1];
          $seoLinkSection = tempSelectVal[1] + '/';
        }
      }
    });
    if ($("input[name='FIELDS[area_from]']").val().length) {
      $selects.push('area[from]=' + $("input[name='FIELDS[area_from]']").val());
      $data['area[from]'] = $("input[name='FIELDS[area_from]']").val();
    }
    if ($("input[name='FIELDS[area_to]']").val().length) {
      $selects.push('area[to]=' + $("input[name='FIELDS[area_to]']").val());
      $data['area[to]'] = $("input[name='FIELDS[area_to]']").val();
    }
    if ($("input[name='FIELDS[price_from]']").val().length) {
      $selects.push('price[from]=' + $("input[name='FIELDS[price_from]']").val());
      $data['price[from]'] = $("input[name='FIELDS[price_from]']").val();
    }
    if ($("input[name='FIELDS[price_to]']").val().length) {
      $selects.push('price[to]=' + $("input[name='FIELDS[price_to]']").val());
      $data['price[to]'] = $("input[name='FIELDS[price_to]']").val();
    }
    if ($("input[name='FIELDS[rooms]']").val().length) {
      $selects.push('rooms=' + $("input[name='FIELDS[rooms]']").val());
      $data['rooms'] = $("input[name='FIELDS[rooms]']").val();
    }
    $selects.sort();
    $.post("/api/create_url_by_params.php", $data, function (responce) {
      $seoLink = responce['url'];
      // console.log($seoLink);
      $("input[name='FIELDS[LINK]']").val($seoLink);
    }, 'json');

    //$seoLink = $baseLink + $seoLinkSection +"?" + $selects.join('&');


  }

  /*скроем ненужные для департамента поля и сделаем недоступным базовую ссылку*/
  if (!$("select[name='FIELDS[department]']").val().length) {
    $('select').each(function (select, val) {
      if ($(this).attr('name') != 'FIELDS[department]') {
        $(this).parent('td').parent('tr').hide();
      }
    });
  } else {
    showActialFields($("select[name='FIELDS[department]']").val());
  }
  $("input[name='FIELDS[base_link]']").parent('td').parent('tr').hide();

  $('select').on("change", function () {
    if ($(this).attr('name') == 'FIELDS[department]') {
      showActialFields($(this).val());
    }
    createUrl();
  });

  $("input[name='FIELDS[area_from]']").on("keyup", function () {
    createUrl();
  });
  $("input[name='FIELDS[area_to]']").on("keyup", function () {
    createUrl();
  });
  $("input[name='FIELDS[price_from]']").on("keyup", function () {
    createUrl();
  });
  $("input[name='FIELDS[price_to]']").on("keyup", function () {
    createUrl();
  });
  $("input[name='FIELDS[rooms]']").on("keyup", function () {
    createUrl();
  });


});
