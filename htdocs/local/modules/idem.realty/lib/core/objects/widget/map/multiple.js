/**
 * Менеджер множественных полей
 * Позволяет добавлять и удалять любой HTML код с возможность подстановки динамических данных
 * Инструкция:
 * - создайте контейнер, где будут хранится отображаться код
 * - создайте экземпляр MultipleWidgetHelper
 * Например: var multiple = MultipleWidgetHelper(селектор контейнера, шаблон)
 * шаблон - это HTML код, который можно будет добавлять и удалять в интерфейсе
 * В шаблон можно добавлять переменные, их нужно обрамлять фигурными скобками. Например {{entity_id}}
 * Если в шаблоне несколько полей, переменная {{field_id}} обязательна
 * Например <input type="text" name="image[{{field_id}}][SRC]"><input type="text" name="image[{{field_id}}][DESCRIPTION]">
 * Если добавляемые поле не новое, то обязательно передавайте в addField переменную field_id с ID записи,
 * для новосозданных полей переменная заполнится автоматически
 */
function MultipleWidgetHelper(container, fieldTemplate, multiple) {
  this.$container = $(container);
  this.$multiple = multiple;
  if (this.$container.size() == 0) {
    throw 'Главный контейнер полей не найден (' + container + ')';
  }
  if (!fieldTemplate) {
    throw 'Не передан обязательный параметр fieldTemplate';
  }
  this.fieldTemplate = fieldTemplate;
  this._init();
}

MultipleWidgetHelper.prototype = {
  /**
   * Основной контейнер
   */
  $container: null,
  $multiple: false,
  /**
   * Контейнер полей
   */
  $fieldsContainer: null,
  /**
   * Шаблон поля
   */
  fieldTemplate: null,
  /**
   * Счетчик добавлений полей
   */
  fieldsCounter: 0,
  /**
   * Добавления поля
   * @param data object Данные для шаблона в виде ключ: значение
   */
  addField: function (data) {
    this.addFieldHtml(this.fieldTemplate, data);
  },
  addFieldHtml: function (fieldTemplate, data) {
    this.fieldsCounter++;
    var counter = this.fieldsCounter;
    if($('#GMapDivnew_'+counter).length) {
      this.fieldsCounter = $('.map-box').length;
      this.fieldsCounter++;
      this.fieldsCounter++;
    }
    this.$fieldsContainer.append(this._generateFieldContent(fieldTemplate, data));
  },
  addMapField: function (data, counter) {
    // console.log('Добавление поля');
    this.addMapFieldHtml(this.fieldTemplate, data, counter);
  },
  addMapFieldHtml: function (fieldTemplate, data, counter) {
    this.fieldsCounter = counter;
    if($('#GMapDivnew_'+counter).length) {
      this.fieldsCounter = $('.map-box').length;
      this.fieldsCounter++;
    }
    this.$fieldsContainer.append(this._generateFieldContent(fieldTemplate, data));
  },
  /**
   * Удаление поля
   * @param field string|object Селектор или jQuery объект
   */
  deleteField: function (field) {
    // console.log('Удаление поля');
    $(field).remove();
    if (this.$fieldsContainer.find('> *').size() == 0) {
      this.addField();
    }
  },
  _init: function () {
    this.$container.append('<div class="fields-container"></div>');
    this.$fieldsContainer = this.$container.find('.fields-container');
    if(this.$multiple)
      this.$container.append(this._getAddButton());

    this._trackEvents();
  },
  /**
   * Генерация контента контейнера поля
   * @param data
   * @returns {string}
   * @private
   */
  _generateFieldContent: function (fieldTemplate, data) {
    var $row = '<div class="field-container" style="margin-bottom: 5px;">'+ this._generateFieldTemplate(fieldTemplate, data);
    if(this.$multiple) {
      $row = $row + this._getDeleteButton();
    }
    $row = $row +  '</div>';
    return $row;
  },
  /**
   * Генерация шаблона поля
   * @param data object Данные для подстановки
   * @returns {null}
   * @private
   */
  _generateFieldTemplate: function (fieldTemplate, data) {
    if (!data) {
      data = {};
    }

    if (typeof data.field_id == 'undefined') {
      data.field_id = 'new_' + this.fieldsCounter;
    }

    $.each(data, function (key, value) {
      // Подставление значений переменных
      fieldTemplate = fieldTemplate.replace(new RegExp('\{\{' + key + '\}\}', ['g']), value);
      fieldTemplate = fieldTemplate.replace(new RegExp('%7B%7B' + key + '%7D%7D', ['g']), value);
    });

    // Удаление из шаблона необработанных переменных
    fieldTemplate = fieldTemplate.replace(/\{\{.+?\}\}/g, '');
    fieldTemplate = fieldTemplate.replace(/%7B%7B.+?%7D%7D/g, '');

    return fieldTemplate;
  },
  /**
   * Кнопка удаления
   * @returns {string}
   * @private
   */
  _getDeleteButton: function () {
    return '<input type="button" value="-" class="delete-field-button" style="margin-left: 5px;">';
  },
  /**
   * Кнопка добавления
   * @returns {string}
   * @private
   */
  _getAddButton: function () {
    return '<input type="button" value="Добавить..." class="add-field-button">';
  },
  /**
   * Отслеживание событий
   * @private
   */
  _trackEvents: function () {
    var context = this;
    // Добавление поля
    this.$container.find('.add-field-button').on('click', function () {
      context.addField();
    });
    // Удаление поля
    this.$container.on('click', '.delete-field-button', function () {
      context.deleteField($(this).parents('.field-container'));
    });
  }
};