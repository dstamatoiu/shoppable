<?php

namespace Plugins\PageBuilder\Addons\Tenants\Common;

use App\Helpers\LanguageHelper;
use App\Helpers\SanitizeInput;

use Plugins\PageBuilder\Fields\IconPicker;
use Plugins\PageBuilder\Fields\Image;
use Plugins\PageBuilder\Fields\Number;
use Plugins\PageBuilder\Fields\Repeater;
use Plugins\PageBuilder\Fields\Slider;
use Plugins\PageBuilder\Fields\Text;
use Plugins\PageBuilder\Helpers\RepeaterField;
use Plugins\PageBuilder\PageBuilderBase;

class FaqOne extends PageBuilderBase
{

    public function preview_image()
    {
        return 'Tenant/common/faq-001.png';
    }

    public function admin_render()
    {
        $output = $this->admin_form_before();
        $output .= $this->admin_form_start();
        $output .= $this->default_fields();

        $widget_saved_values = $this->get_settings();
        $output .= $this->admin_language_tab(); //have to start language tab from here on
        $output .= $this->admin_language_tab_start();
        $all_languages = LanguageHelper::all_languages();

        foreach ($all_languages as $key => $lang) {
            $output .= $this->admin_language_tab_content_start([
                'class' => $key == 0 ? 'tab-pane fade show active' : 'tab-pane fade',
                'id' => "nav-home-" . $lang->slug
            ]);
            $output .= Text::get([
                'name' => 'title_' . $lang->slug,
                'label' => __('Top Title'),
                'value' => $widget_saved_values['title_' . $lang->slug] ?? null,
            ]);
            $output .= Text::get([
                'name' => 'newsletter_title_' . $lang->slug,
                'label' => __('Newsletter Title'),
                'value' => $widget_saved_values['newsletter_title_' . $lang->slug] ?? null,
            ]);
            $output .= Text::get([
                'name' => 'newsletter_subtitle_' . $lang->slug,
                'label' => __('Newsletter Subtitle'),
                'value' => $widget_saved_values['newsletter_subtitle_' . $lang->slug] ?? null,
            ]);
            $output .= Text::get([
                'name' => 'button_text_' . $lang->slug,
                'label' => __('Submit Button Text'),
                'value' => $widget_saved_values['button_text_' . $lang->slug] ?? null,
            ]);

            $output .= $this->admin_language_tab_content_end();
        }
        $output .= $this->admin_language_tab_end(); //have to end language tab


        //repeater
        $output .= Repeater::get([
            'multi_lang' => true,
            'settings' => $widget_saved_values,
            'id' => 'faq_one_repeater',
            'fields' => [
                [
                    'type' => RepeaterField::TEXT,
                    'name' => 'repeater_title',
                    'label' => __('Title')
                ],
                [
                    'type' => RepeaterField::TEXTAREA,
                    'name' => 'repeater_description',
                    'label' => __('Description')
                ],
            ]
        ]);


        // add padding option
        $output .= $this->padding_fields($widget_saved_values);
        $output .= $this->admin_form_submit_button();
        $output .= $this->admin_form_end();
        $output .= $this->admin_form_after();

        return $output;
    }

    public function frontend_render()
    {
        $current_lang = LanguageHelper::user_lang_slug();
        $title = $this->setting_item('title_' . $current_lang) ?? '';
        $newsletter_title = $this->setting_item('newsletter_title_' . $current_lang) ?? '';
        $newsletter_subtitle = $this->setting_item('newsletter_subtitle_' . $current_lang) ?? '';
        $button_text = $this->setting_item('button_text_' . $current_lang) ?? '';
        $padding_top = SanitizeInput::esc_html($this->setting_item('padding_top'));
        $padding_bottom = SanitizeInput::esc_html($this->setting_item('padding_bottom'));
        $repeater_data = $this->setting_item('faq_one_repeater');

        $data = [
            'title' => $title,
            'newsletter_title' => $newsletter_title,
            'newsletter_subtitle' => $newsletter_subtitle,
            'button_text' => $button_text,
            'padding_top' => $padding_top,
            'padding_bottom' => $padding_bottom,
            'repeater_data' => $repeater_data,
        ];

        return self::renderView('tenant.common.faq-one', $data);

    }

    public function enable(): bool
    {
        return (bool) !is_null(tenant());
    }

    public function addon_title()
    {
        return __('Faq : 01');
    }
}
