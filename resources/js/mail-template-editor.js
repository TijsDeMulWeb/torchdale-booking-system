import Quill from 'quill';
import 'quill/dist/quill.snow.css';

var SizeStyle = Quill.import('attributors/style/size');
SizeStyle.whitelist = ['12px', '14px', '16px', '20px', '24px', '32px', '40px'];
Quill.register(SizeStyle, true);

var AlignStyle = Quill.import('attributors/style/align');
var ColorStyle = Quill.import('attributors/style/color');
var BackgroundStyle = Quill.import('attributors/style/background');
Quill.register(AlignStyle, true);
Quill.register(ColorStyle, true);
Quill.register(BackgroundStyle, true);

var editorEl = document.getElementById('quill-editor');
if (editorEl) {
    var config = window.mailTemplateConfig || {};

    var quill = new Quill(editorEl, {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ size: ['12px', false, '16px', '20px', '24px', '32px', '40px'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'image'],
                ['clean'],
            ],
        },
    });

    var bodyField = document.getElementById('body');

    // Oude sjablonen zijn opgeslagen als platte tekst met regeleinden. Zet elke
    // alinea om in een eigen <p>, zodat uitlijning per alinea kan worden ingesteld
    // i.p.v. op de hele inhoud tegelijk.
    function legacyTextToHtml(text) {
        if (/<p[\s>]|<div[\s>]|<br/i.test(text)) {
            return text;
        }
        return text.split(/\n\n+/).map(function (paragraph) {
            return '<p>' + paragraph.replace(/\n/g, '<br>') + '</p>';
        }).join('');
    }

    if (bodyField.value.trim() !== '') {
        quill.setContents([]);
        quill.clipboard.dangerouslyPasteHTML(0, legacyTextToHtml(bodyField.value), 'silent');
    }

    quill.getModule('toolbar').addHandler('image', function () {
        document.getElementById('image-upload-input').click();
    });

    document.getElementById('mail-template-form').addEventListener('submit', function () {
        bodyField.value = quill.root.innerHTML;
    });

    window.insertVariable = function (variable) {
        var range = quill.getSelection(true) || { index: quill.getLength(), length: 0 };
        var index = range.index;

        if (variable === '{{product_image}}') {
            // Op een eigen regel zodat de afbeelding apart uitgelijnd kan worden.
            quill.insertText(index, '\n', 'user');
            quill.insertText(index + 1, variable, 'user');
            quill.insertText(index + 1 + variable.length, '\n', 'user');
            quill.setSelection(index + 1 + variable.length, 0);
            return;
        }

        quill.insertText(index, variable, 'user');
        quill.setSelection(index + variable.length, 0);
    };

    window.uploadImage = function (input) {
        var file = input.files[0];
        if (!file) {
            return;
        }

        var status = document.getElementById('image-upload-status');
        status.textContent = 'Bezig met uploaden...';

        var formData = new FormData();
        formData.append('image', file);
        formData.append('_token', config.csrfToken || '');

        fetch(config.uploadImageUrl, {
            method: 'POST',
            body: formData,
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Upload mislukt');
                }
                return response.json();
            })
            .then(function (data) {
                var range = quill.getSelection(true) || { index: quill.getLength(), length: 0 };
                var index = range.index;

                // Plaats de afbeelding op een eigen regel, zodat ze los uitgelijnd
                // kan worden (links/midden/rechts) zonder de omliggende tekst te raken.
                quill.insertText(index, '\n', 'user');
                quill.insertEmbed(index + 1, 'image', data.url, 'user');
                quill.insertText(index + 2, '\n', 'user');
                quill.setSelection(index + 1, 0);
                status.textContent = '';
            })
            .catch(function () {
                status.textContent = 'Uploaden mislukt.';
            })
            .finally(function () {
                input.value = '';
            });
    };
}
