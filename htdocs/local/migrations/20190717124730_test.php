<?php

use Phinx\Migration\AbstractMigration;
use Idem\Realty\Utilities\Migration;

class Test extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        /* $this->addPageTitleOption();
        $this->createBlocks();
        $this->addContent(); */
        
    }
    
    public function down()
    {
        /* $this->removeContent();
        $this->removeBlocks();
        $this->removePageTitleOption(); */
        
    }
    
    private function addContent()
    {
        $this->createProducts();
        $this->createNews();
        $this->createProcess();
        $this->createHistory();
        $this->createExperience();
        $this->createServices();
        $this->createWhyWe();
        $this->createAbout();
        $this->setSiteSettings();
    }
    private function createBlocks()
    {
        MigrationHelper::createType('content',[
            'ID'=>'content',
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                'ru'=>[
                    'NAME'=>'Контент',
                    'SECTION_NAME'=>'Секция',
                    'ELEMENT_NAME'=>'Элемент'
                ]
            ]
        ]);
        MigrationHelper::createIBlock([
            'LID' => 's1',
            'CODE' => 'about_items',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'О компании',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Файл иконки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON_FILE",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'about_items'])
        ]);
        MigrationHelper::createIBlock([
            'LID' => 's1',
            'CODE' => 'why_we',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Почему мы',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Файл иконки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON_FILE",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'why_we'])
        ]);
        MigrationHelper::createIBlock([
            'LID' => 's1',
            'CODE' => 'news',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Новости',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        MigrationHelper::createIBlock([
            'LID' => 's1',
            'CODE' => 'production',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Продукция',
            'ACTIVE' => 'Y',
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Стоимость",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "PRICE",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'production'])
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Характеристики",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "OPTIONS",
            "PROPERTY_TYPE" => "S",
            "MULTIPLE" => "Y",
            "WITH_DESCRIPTION" => "Y",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'production'])
        ]);
        MigrationHelper::createIBlock([
            'LID' => 's1',
            'CODE' => 'service',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Услуги',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Файл иконки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON_FILE",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'service'])
        ]);
        MigrationHelper::createIBlock([
            'LID' => 's1',
            'CODE' => 'experience',
            'IBLOCK_TYPE_ID' => 'content',
            'NAME' => 'Опыт в производстве',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Файл иконки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON_FILE",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'experience'])
        ]);
        MigrationHelper::createIBlock([
            'CODE' => 'process',
            'NAME' => 'Процесс работы',
            'IBLOCK_TYPE_ID' => 'content',
            'LID' => 's1',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Файл иконки",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "ICON_FILE",
            "PROPERTY_TYPE" => "F",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'process'])
        ]);
        MigrationHelper::createProperties([
            "NAME" => "Имя навигации",
            "ACTIVE" => "Y",
            "SORT" => "100",
            "CODE" => "NAV_TEXT",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => MigrationHelper::getIBlockIdByFilter(['CODE' => 'process'])
        ]);
        MigrationHelper::createIBlock([
            'CODE' => 'history',
            'NAME' => 'История развития',
            'IBLOCK_TYPE_ID' => 'content',
            'LID' => 's1',
            'ACTIVE' => 'Y',
            "GROUP_ID" => Array("2" => "R", "11" => "X"),
            'INDEX_ELEMENT' => 'N',
            'INDEX_SECTION' => 'N',
            'SECTION_CHOOSER' => 'D',
            'VERSION' => '2',
        ]);
    }
    private function addPageTitleOption()
    {
        $res = unserialize(COption::GetOptionString('fileman','propstypes'));
        $res['page_title'] = 'Заголовок страницы';
        COption::RemoveOption('fileman','propstypes');
        COption::SetOptionString('fileman','propstypes',serialize($res));
    }
    private function removePageTitleOption()
    {
        $res = unserialize(COption::GetOptionString('fileman','propstypes'));
        unset($res['page_title']);
        COption::RemoveOption('fileman','propstypes');
        COption::SetOptionString('fileman','propstypes',serialize($res));
    }
    private function removeContent()
    {
        $arBlocks = [
            'history',
            'about_items',
            'why_we',
            'news',
            'production',
            'service',
            'experience',
            'process',
        ];
        
        foreach ($arBlocks as $block){
            MigrationHelper::removeAllInIBlock($block);
        }
    }
    private function removeBlocks(){
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'service']));
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'about_items']));
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'why_we']));
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'news']));
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'production']));
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'experience']));
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'history']));
        MigrationHelper::deleteIBlock(MigrationHelper::getIBlockIdByFilter(['CODE' => 'process']));
        MigrationHelper::deleteType('content');
    }
    
    private function createNews()
    {
        $path = $path = __DIR__ . '/assets/news/';
        $files = ['1.jpg','2.jpg','3.jpg'];
        $iBlockId = MigrationHelper::getIBlockIdByFilter(['CODE' => 'news']);
        foreach ($files as $key => $file) {
            
            $filePath = $path.$file;
            $fileId = CFile::MakeFileArray($filePath);
            $arData = [
                "IBLOCK_ID" => $iBlockId,
                "NAME" => "Технологические процессы лазерной обработки " . $key,
                "PREVIEW_TEXT" => 'Компания имеет опыт производства сложных и высокоточных, благодаря этому мы можем сделать всё что требуется клиенту.',
                "DETAIL_TEXT" => '',
                "PREVIEW_PICTURE" => $fileId
            ];
            MigrationHelper::createElement($arData);
        }
        
    }
    private function createAbout()
    {
        $iBlockId = MigrationHelper::getIBlockIdByFilter(['CODE' => 'about_items']);
        $path = __DIR__ . '/assets/about/';
        $f1 = CFile::MakeFileArray($path . '1.svg');
        $f2 = CFile::MakeFileArray($path . '2.svg');
        $f3 = CFile::MakeFileArray($path . '3.svg');
        $f4 = CFile::MakeFileArray($path . '4.svg');
        $f5 = CFile::MakeFileArray($path . '5.svg');
        $f6 = CFile::MakeFileArray($path . '6.svg');
        $f7 = CFile::MakeFileArray($path . '7.svg');
        $f8 = CFile::MakeFileArray($path . '8.svg');
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Макетов конструкций",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f1
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Спец. инструментов",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f2
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Корпусных решений для приборов",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f3
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Оснастки для станков и сборок",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f4
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Элементов ракетных двигателей",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f5
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Испытательных стендов",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f6
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Деталей систем позиционирования",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f7
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Аэродинамических стабилизирующих поверхностей",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f8
            ]
        ]);
    }
    private function createWhyWe()
    {
        $iBlockId = MigrationHelper::getIBlockIdByFilter(['CODE' => 'why_we']);
        $path = __DIR__ . '/assets/why_we/';
        $f1 = CFile::MakeFileArray($path . '1.svg');
        $f2 = CFile::MakeFileArray($path . '2.svg');
        $f3 = CFile::MakeFileArray($path . '3.svg');
        $f4 = CFile::MakeFileArray($path . '4.svg');
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Высокая скорость производства",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f1
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Современные технологии",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f2
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "Квалифицированные специалисты",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f3
            ]
        ]);
        MigrationHelper::createElement([
            "IBLOCK_ID" => $iBlockId,
            "NAME" => "	Индивидуальный подход",
            "PROPERTY_VALUES" => [
                "ICON_FILE" => $f4
            ]
        ]);
    }
    private function createProducts()
    {
        $path = __DIR__ . '/assets/production/';
        $files = ['1.jpg','2.jpg','3.jpg','4.jpg'];
        $iBlockId = MigrationHelper::getIBlockIdByFilter(['CODE' => 'production']);
        
        foreach ($files as $key => $file) {
            /**
             * @var $file SplFileInfo
             */
            $fileId = CFile::MakeFileArray($path.$file);
            $price = rand(3000, 5000);
            
            MigrationHelper::createElement([
                "IBLOCK_ID" => $iBlockId,
                "NAME" => "Корпус теплообменника " . $key,
                "DETAIL_TEXT" => 'Часовой выпуск деталей - это основной показатель эффективности операций токарной обработки, особенно при крупносероийном производстве. Для максимального увеличения этого показателя очень важна качественная система ЧПУ, способная управлять множеством технологических процессов и оптимизировать их. Кроме того, и станок, и ЧПУ должны быть относительно удобны в использовании и соответствовать признанным единым стандартам. Это не только позволяет сэкономить ценное производственное время, но и упрощает поиск квалифицированных операторов.',
                "PREVIEW_PICTURE" => $fileId,
                "PROPERTY_VALUES" => [
                    "PRICE" => "от $price руб.",
                    "OPTIONS" => [
                        ["VALUE" => "Свойство 1", "DESCRIPTION" => "Заначение 1"],
                        ["VALUE" => "Свойство 2", "DESCRIPTION" => "Заначение 2"],
                        ["VALUE" => "Свойство 3", "DESCRIPTION" => "Заначение 3"],
                        ["VALUE" => "Свойство 4", "DESCRIPTION" => "Заначение 4"],
                    ]
                ]
            ],true);
        }
    }
    private function createServices()
    {
        $files = __DIR__ . '/assets/service/';
        $iBlockId = MigrationHelper::getIBlockIdByFilter(['CODE' => 'service']);
        $fileId1 = CFile::MakeFileArray($files . '1.jpg');
        $fileId2 = CFile::MakeFileArray($files . 'full.jpg');
        $fileId3 = CFile::MakeFileArray($files . '1.svg');
        for ($i = 0; $i < 5; $i++) {
            
            MigrationHelper::createElement([
                "IBLOCK_ID" => $iBlockId,
                "NAME" => "Токарная и высокоскоростная токарная обработка " . $i + 1,
                "PREVIEW_TEXT" => "Технология токарных работ по металлу предполагает использование специальных станков и режущего инструмента (резцы, сверла, развертки и др.), посредством которого с детали снимается слой металла требуемой величины.",
                "DETAIL_TEXT" => 'Часовой выпуск деталей - это основной показатель эффективности операций токарной обработки, особенно при крупносероийном производстве. Для максимального увеличения этого показателя очень важна качественная система ЧПУ, способная управлять множеством технологических процессов и оптимизировать их. Кроме того, и станок, и ЧПУ должны быть относительно удобны в использовании и соответствовать признанным единым стандартам. Это не только позволяет сэкономить ценное производственное время, но и упрощает поиск квалифицированных операторов.',
                "PREVIEW_PICTURE" => $fileId1,
                "DETAIL_PICTURE" => $fileId2,
                "PROPERTY_VALUES" => [
                    "ICON_FILE" => $fileId3,
                ]
            ]);
        }
    }
    private function createExperience()
    {
        $filePath = __DIR__ . '/assets/experience/';
        $data = [
            ['text' => 'Деталей систем <br>позиционирования', 'icon' => '1.svg'],
            ['text' => 'Элементов ракетных <br>двигателей', 'icon' => '2.svg'],
            ['text' => 'Корпусных решений <br>для приборов', 'icon' => '3.svg'],
            ['text' => 'Аэродинамических <br>стабилизирующих <br>поверхностей', 'icon' => '4.svg'],
            ['text' => 'Испытательных <br>стендов', 'icon' => '5.svg'],
            ['text' => 'Оснастки для станков <br>и сборок', 'icon' => '6.svg'],
            ['text' => 'Спец, инструментов', 'icon' => '7.svg'],
            ['text' => 'Макетов конструкций', 'icon' => '8.svg'],
        ];
        
        $iblockID = MigrationHelper::getIBlockIdByFilter(['CODE' => 'experience']);
        
        foreach ($data as $item) {
            $fID = CFile::MakeFileArray($filePath . $item['icon']);
            MigrationHelper::createElement([
                "IBLOCK_ID" => $iblockID,
                "NAME" => strip_tags($item['text']),
                "PREVIEW_TEXT" => $item['text'],
                "PROPERTY_VALUES" => [
                    "ICON_FILE" => $fID,
                ]
            ]);
        }
    }
    private function createHistory()
    {
        $filePath = __DIR__ . '/assets/history/';
        $data = [
            ['name' => '1995', 'image' => '1995.jpg'],
            ['name' => '1996', 'image' => '1996.jpg'],
            ['name' => '1998', 'image' => '1998.jpg'],
            ['name' => '2001', 'image' => '2001.jpg'],
            ['name' => '2008', 'image' => '2008.jpg'],
            ['name' => '2010', 'image' => '2010.jpg'],
            ['name' => '2012', 'image' => '2012.jpg'],
            ['name' => '2015', 'image' => '2015.jpg'],
            ['name' => '2017', 'image' => '2017.jpg'],
        ];
        
        $iblockID = MigrationHelper::getIBlockIdByFilter(['CODE' => 'history']);
        
        
        foreach ($data as $key => $item) {
            MigrationHelper::createElement([
                "IBLOCK_ID" => $iblockID,
                "NAME" => $item['name'],
                "PREVIEW_TEXT" => 'Год образования компании. Компания имеет опыт развития сложных и высокоточных изделий, благодаря этому мы можем сделать то, что нужно клиенту. Год образования компании. Компания имеет опыт развития сложных и высокоточных изделий, благодаря этому мы можем сделать то, что нужно клиенту.',
                "SORT" => $key + 1,
                "PREVIEW_PICTURE" => CFile::MakeFileArray($filePath . $item['image'])
            ]);
        }
    }
    private function createProcess()
    {
        $filePath = __DIR__ . '/assets/process/';
        $data = [
            [
                'name' => 'Вы звоните нам или оставляете заявку',
                'image' => '1.svg',
                'text' => 'Связаться с нами можно по телефону +7 (956) 456-78-88 или отправив
                                    письмо с описанием вашей заявки на наш электронный адрес
                                    <a href="mailto:engineering88@gmail.com">engineering88@gmail.com</a>',
                'nav_text' => 'Звонок и составление заявки',
            ],
            [
                'name' => 'Договариваемся о бесплатном выезде нашего специалиста в удобное для Вас время',
                'image' => '2.svg',
                'text' => 'Мы всегда стараемся быть максимально открыты и честны
                                    по отношению к клиентам. Во время проекта все ключевые решения,
                                    влияющие на ход работ, принимаются совместно с заказчиком.',
                'nav_text' => 'Договариваемся о встрече',
            ],
            [
                'name' => 'Перед выездом наш специалист связывается с вами, подтверждая встречу',
                'image' => '3.svg',
                'text' => 'Во время проекта все ключевые решения, влияющие на ход работ,
                                    принимаются совместно с заказчиком.',
                'nav_text' => 'Выезд специалиста',
            ],
            [
                'name' => 'Доставляем материалы',
                'image' => '4.svg',
                'text' => 'Мы всегда стараемся быть максимально открыты и честны </br>
                                    по отношению к клиентам.',
                'nav_text' => 'Доставляем материалы',
            ],
            [
                'name' => 'Согласовываются условия и подписывается договор',
                'image' => '5.svg',
                'text' => 'Мы всегда стараемся быть максимально открыты и честны
                                    по отношению к клиентам. Во время проекта все ключевые решения,
                                    влияющие на ход работ, принимаются совместно с заказчиком',
                'nav_text' => 'Подписываем договор',
            ],
            [
                'name' => 'Составляется ориентировочная смета на работы и черновые материалы',
                'image' => '6.svg',
                'text' => 'Во время проекта все ключевые решения, влияющие на ход работ,
                                    принимаются совместно с заказчиком. Мы всегда стараемся быть
                                    максимально открыты и честны по отношению к клиентам.',
                'nav_text' => 'Смета на работы и материалы',
            ],
            [
                'name' => 'Наши мастера выполняют работы',
                'image' => '7.svg',
                'text' => 'Мы всегда стараемся быть максимально открыты и честны </br>
                                    по отношению к клиентам.',
                'nav_text' => 'Мастера выполняют работы',
            ],
            [
                'name' => 'Вы оплачиваете работы поэтапно, по факту их выполнения',
                'image' => '8.svg',
                'text' => 'Во время проекта все ключевые решения, влияющие на ход работ,
                                    принимаются совместно с заказчиком',
                'nav_text' => 'Поэтапная оплата работы',
            ],
            [
                'name' => 'Работы окончены качественно и в срок',
                'image' => '9.svg',
                'text' => 'Во время проекта все ключевые решения, влияющие на ход работ,
                                    принимаются совместно с заказчиком. Мы всегда стараемся быть
                                    максимально открыты и честны по отношению к клиентам.',
                'nav_text' => 'Окончание выполнения работ',
            ],
        ];
        
        $iblockID = MigrationHelper::getIBlockIdByFilter(['CODE' => 'process']);
        
        
        foreach ($data as $key => $item) {
            MigrationHelper::createElement([
                "IBLOCK_ID" => $iblockID,
                "NAME" => $item['name'],
                "PREVIEW_TEXT" => $item['text'],
                "SORT" => $key + 1,
                "PROPERTY_VALUES" => [
                    'ICON_FILE' => CFile::MakeFileArray($filePath . $item['image']),
                    'NAV_TEXT' => $item['nav_text']
                ]
            ]);
        }
    }
    private function setSiteSettings(){
        $arFields = Array(
            "LID"              => 's1',
            "ACTIVE"           => "Y",
            "SORT"             => '100',
            "DEF"              => "N",
            "NAME"             => 'Инженерные решения',
            "DIR"              => '/',
            "FORMAT_DATE"      => "DD.MM.YYYY",
            "FORMAT_DATETIME"  => "DD.MM.YYYY HH:MI:SS",
            "CHARSET"          => "UTF-8",
            "SITE_NAME"        => 'Инженерные решения',
            "SERVER_NAME"      => "",
            "EMAIL"            => "",
            "LANGUAGE_ID"      => "ru",
            "DOC_ROOT"         => "",
            "DOMAINS"          => "",
            "TEMPLATE"         => Array(
                Array(
                    "TEMPLATE" => "engine-solution",
                    "SORT" => 1,
                    "CONDITION" => ""
                )
            )
        );
        $obSite = new CSite;
        $obSite->Update('s1',$arFields);
    }
    
}
