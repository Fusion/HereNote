Quill.registerModule('tbcode', function(quill, options) {
    quill.addFormat('code', { tag: 'code', attribute: 'class' });
    // Nope quill.options.formats.push('code');

    quill.onModuleLoad('toolbar', function(toolbar) {
        toolbar.initFormat('code', function() {
            var range = quill.getSelection();
            if(!range)
                return;
            if(range.start == range.end) {
                // We are trying to switch to this mode
                quill.insertText(range.end, "\n```\n\n```\n");
                        quill.setSelection(range.end + 5, range.end + 5);
            }
            else {
                // See if we are already in a code block
                var leaf = quill.editor.doc.findLeafAt(range.start, true)[0];
                if(!leaf)
                    return;
                var node = leaf.node;
                while(node && node != quill.root) {
                    if(node.tagName == 'code')
                        break;
                    node = node.parentElement;
                }
                if(node.class == 'code') {
                    // we already are in a code block
                }
                else {
                    if(!range.isCollapsed()) {
                        // This does not work quill.insertEmbed(range.end, 'code', '[CODE]', 'user');
                        // quill.formatText(range.start, range.end, 'code', 'code', 'user');
                        quill.insertText(range.end, "\n```\n");
                        quill.insertText(range.start, "\n```\n");
                        quill.setSelection(range.end + 9, range.end + 9);
                    }
                }
            }
        }, this);
    });
});

Quill.registerModule('tbundo', function(quill, options) {
    quill.addFormat('undo', { tag: 'undo', attribute: 'class' });
    quill.addFormat('redo', { tag: 'redo', attribute: 'class' });

    quill.onModuleLoad('toolbar', function(toolbar) {
        toolbar.initFormat('undo', function() {
            var undoManager = quill.getModule('undo-manager');
            undoManager.undo();
        }, this);
        toolbar.initFormat('redo', function() {
            var undoManager = quill.getModule('undo-manager');
            undoManager.redo();
        }, this);
    });
});
