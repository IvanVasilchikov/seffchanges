<?php

CModule::AddAutoloadClasses(
    "idem",
    [
        "Idem\CIdemStatic" => "classes/general/idem_static.php",
        "Idem\CIdemForm" => "classes/general/form.php",
        "Idem\CIdemFileInfo" => "classes/general/files_info_converter.php",
    ]
);