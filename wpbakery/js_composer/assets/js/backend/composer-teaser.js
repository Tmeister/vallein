/* =========================================================
 * composer-teaser.js v1.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer custom teaser block control meta box.
 * ========================================================= */
(function ($) {
    var VCTeaser = Backbone.View.extend({
        el:$('#vc_teaser'),
        events: {
            'click #vc-teaser-checkbox': 'toggle',
            'change [name=vc_sorted_list_element]': 'updateList'
        },
        blocks: [

        ],
        initialize: function() {
            _.bindAll(this, 'updateColorPicker', 'clearColorPicker');
            this.render();
        },
        render: function(){
            this.$contructor_container = this.$el.find('.vc-teaser-constructor');
            this.$toolbar = this.$contructor_container.find('.vc-toolbar');
            this.$list = this.$contructor_container.find('.vc-teaser-list');
            this.$contructor_container.find('.vc-teaser-bgcolor').wpColorPicker({
                change:this.updateColorPicker,
                clear: this.clearColorPicker
            });
        },
        toggle: function(e) {
            var $target = $(e.currentTarget);
            if($target.is(':checked')) {
                this.$contructor_container.show();
            } else {
                this.$contructor_container.hide();
            }
        },
        updateColorPicker: function(e, ui){
            var color = ui ? ui.color.toString() : '';
            this.$list.css('backgroundColor', color);
        },
        clearColorPicker: function() {
            this.$list.css('backgroundColor', '');
        },
        updateList: function(e) {
            var $control = $(e.currentTarget);
            if($control.is(':checked')) {
                this.createControl({
                    value: $control.val(),
                    label: $control.parent().text(),
                    sub: $control.data('subcontrol')
                });

            } else {
                this.$list.find('.vc-control-' + $control.val()).remove();
            }
        },
        createControl: function(data) {
            var sub_control = '',
                selected_sub_value = _.isUndefined(data.sub_value) ? [] : data.sub_value;
            if(_.isArray(data.sub)) {
                _.each(data.sub, function(sub, index){
                    sub_control += ' <select>';
                    _.each(sub, function(item){
                        sub_control += '<option value="' + item[0] + '"' + (_.isString(selected_sub_value[index]) && selected_sub_value[index]===item[0] ? ' selected="true"' : '') + '>' + item[1] + '</option>';
                    });
                    sub_control += '</select>';
                }, this);

            }
            this.$list.append('<li class="vc-control-' + data.value + '" data-name="' + data.value + '">' + this.getDataHtml(data) + sub_control + '</li>');
        },
        getDataHtml: function(data) {
            data.value
        }
    });
    $(function(){
        if ($('#vc_teaser').is('div')) {
            vc.teaser = new VCTeaser();
        }
    });
})(window.jQuery);