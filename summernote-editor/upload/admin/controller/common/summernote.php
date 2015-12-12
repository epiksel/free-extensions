<?php
class ControllerCommonSummernote extends Controller {
    public function index() {
        $settings = $this->config->get('epiksel_summernote_setting');
        $server = ($this->request->server['HTTPS']) ?  HTTPS_CATALOG : HTTP_CATALOG;

        $codemirror = "";

        if ($settings['status']) {
            $language = ($settings['editor_lang']) ? $settings['editor_lang'] : 'en-US';
            $height = ($settings['editor_height']) ? $settings['editor_height'] : '400';

            $codemirror .= '<link type="text/css" href="' . $server . '/epiksel/summernote-editor/javascript/summernote/summernote.css" rel="stylesheet" />' . "\r\n";

            if ($settings['codemirror_status']) {
                $codemirror .= '<link type="text/css" href="' . $server . '/epiksel/summernote-editor/javascript/codemirror/codemirror.min.css" rel="stylesheet" media="screen" />' . "\r\n";
                if ($settings['codemirror_theme']) {
                    $codemirror .= '<link type="text/css" href="' . $server . '/epiksel/summernote-editor/javascript/codemirror/theme/' . $settings["codemirror_theme"] . '.css" rel="stylesheet" media="screen" />' . "\r\n";
                }
                $codemirror .= '<script type="text/javascript" src="' . $server . '/epiksel/summernote-editor/javascript/codemirror/codemirror.min.js"></script>' . "\r\n";
                $codemirror .= '<script type="text/javascript" src="' . $server . '/epiksel/summernote-editor/javascript/codemirror/xml.min.js"></script>' . "\r\n";
                $codemirror .= '<script type="text/javascript" src="' . $server . '/epiksel/summernote-editor/javascript/codemirror/formatting.min.js"></script>' . "\r\n";
            }

            $codemirror .= '<script type="text/javascript" src="' . $server . '/epiksel/summernote-editor/javascript/summernote/summernote.min.js"></script>' . "\r\n";
            $codemirror .= '<style type="text/css">.note-toolbar.panel-heading i{font-size: 14px;}</style>' . "\r\n";
            $codemirror .= '<script type="text/javascript"><!--' . "\r\n";

            $codemirror .= "function getSummernote(selector) {" . "\r\n";
            $codemirror .= "    $(selector).summernote({" . "\r\n";
            $codemirror .= "        lang: '" . $language . "'," . "\r\n";  // Your language
            $codemirror .= "        height: " . (int)$height . "," . "\r\n"; // Editor height
            $codemirror .= "        tabsize: 2," . "\r\n"; // Line tab size
            if ($settings['editor_direction']) {
            $codemirror .= "        direction: 'rtl,'" . "\r\n";
            }
            if ($settings['prettify_status']) {
            $codemirror .= "        prettifyHtml: false," . "\r\n";
            }
            if ($settings['codemirror_status']) {
            $codemirror .= "        codemirror: {" . "\r\n"; // codemirror options
            if ($settings['codemirror_theme']) {
            $codemirror .= "            theme: '" . $settings['codemirror_theme'] . "'," . "\r\n";
            }
            $codemirror .= "            lineNumbers: true," . "\r\n";
            $codemirror .= "            lineWrapping: true" . "\r\n";
            $codemirror .= "        }," . "\r\n";
            }
            $codemirror .= "        toolbar: [" . "\r\n";
            $codemirror .= "            ['style', ['style']]," . "\r\n";
            $codemirror .= "            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']]," . "\r\n";
            $codemirror .= "            ['fontname', ['fontname']]," . "\r\n";
            $codemirror .= "            ['fontsize', ['fontsize']]," . "\r\n";
            $codemirror .= "            ['color', ['color']]," . "\r\n";
            $codemirror .= "            ['para', ['ul', 'ol', 'paragraph']]," . "\r\n";
            $codemirror .= "            ['height', ['height']]," . "\r\n";
            $codemirror .= "            ['undo', ['undo', 'redo']]," . "\r\n";
            $codemirror .= "            ['table', ['table']]," . "\r\n";
            $codemirror .= "            ['insert', ['link', 'picture', 'video', 'hr']]," . "\r\n";
            if ($settings['prettify_status']) {
            $codemirror .= "            ['view', ['fullscreen', 'highlight', 'codeview']]," . "\r\n";
            } else {
            $codemirror .= "            ['view', ['fullscreen', 'codeview']]," . "\r\n";
            }
            $codemirror .= "            ['help', ['help']]" . "\r\n";
            $codemirror .= "        ]" . "\r\n";
            $codemirror .= "    });" . "\r\n";
            $codemirror .= "};" . "\r\n";

            $codemirror .= '//--></script>' . "\r\n";
        } else {
            $codemirror .= '<link type="text/css" href="view/javascript/summernote/summernote.css" rel="stylesheet" />' . "\r\n";
            $codemirror .= '<script type="text/javascript" src="view/javascript/summernote/summernote.min.js"></script>' . "\r\n";

            $codemirror .= '<script type="text/javascript"><!--' . "\r\n";

            $codemirror .= "function getSummernote(selector) {" . "\r\n";
            $codemirror .= "    $(selector).summernote({height: 300});" . "\r\n";
            $codemirror .= "};" . "\r\n";

            $codemirror .= '//--></script>' . "\r\n";
        }

        return $codemirror;
    }
}