function ScnColorPicker(h, i, f) {
    
    this.parentControl = i;
    this.textInputControl = null;
    this.width = 250;
    
    this.init = function(){    
        this.buildTextInputControl();    
    };

    this.buildTextInputControl = function(){  
        var inputElement = '<input data-hex="true" type="text" id="scn-value-' + h.id + '" class="mColorPickerInput mColorPicker colorpicker txt input-text" name="scn_color_value_' + h.id + '" />'; 
        this.textInputControl = jQuery(inputElement);
        this.parentControl.append(this.textInputControl);
    };

    this.init();
}
