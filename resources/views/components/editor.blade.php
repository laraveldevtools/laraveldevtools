<div wire:ignore x-data="{
    monacoContent: '',
    monacoLanguage: 'php',
    monacoPlaceholder: true,
    monacoPlaceholderText: 'Start typing here',
    monacoLoader: true,
    monacoFontSize: '13px',
    monacoId: $id('monaco-editor'),
    monacoEditor(editor){
        editor.onDidChangeModelContent((e) => {
            this.monacoContent = editor.getValue();
            this.updatePlaceholder(editor.getValue());
        });

        editor.onDidBlurEditorWidget(() => {
            this.updatePlaceholder(editor.getValue());
        });

        editor.onDidFocusEditorWidget(() => {
            this.updatePlaceholder(editor.getValue());
        });
    },
    editor(){
        return document.getElementById(this.monacoId).editor;
    },
    setValue(value) {
        this.editor().getModel().setValue(value);
    },
    updatePlaceholder: function(value) {
        if (value == '') {
            this.monacoPlaceholder = true;
            return;
        }
        this.monacoPlaceholder = false;
    },
    monacoEditorFocus(){
        document.getElementById(this.monacoId).dispatchEvent(new CustomEvent('monaco-editor-focused', { monacoId: this.monacoId }));
    },
    monacoEditorAddLoaderScriptToHead() {
        script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs/loader.min.js';
        document.head.appendChild(script);
    }
}"
x-init="
    window.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 's') {
            e.preventDefault();
            $wire.saveFileContents(document.getElementById(monacoId).editor.getValue());
        }
    });
        
    if(typeof _amdLoaderGlobal == 'undefined'){
        monacoEditorAddLoaderScriptToHead();
    }

    monacoLoaderInterval = setInterval(function(){
        if(typeof _amdLoaderGlobal !== 'undefined'){

            // Based on https://jsfiddle.net/developit/bwgkr6uq/ which works without needing service worker. Provided by loader.min.js.
            require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs' }});
            let proxy = URL.createObjectURL(new Blob([` self.MonacoEnvironment = { baseUrl: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min' }; importScripts('https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs/base/worker/workerMain.min.js');`], { type: 'text/javascript' }));
            window.MonacoEnvironment = { getWorkerUrl: () => proxy };

            require(['vs/editor/editor.main'], function() {
                
                //monacoTheme = {'base':'vs-dark','inherit':true,'rules':[{'background':'0C1021','token':''},{'foreground':'aeaeae','token':'comment'},{'foreground':'d8fa3c','token':'constant'},{'foreground':'ff6400','token':'entity'},{'foreground':'fbde2d','token':'keyword'},{'foreground':'fbde2d','token':'storage'},{'foreground':'61ce3c','token':'string'},{'foreground':'61ce3c','token':'meta.verbatim'},{'foreground':'8da6ce','token':'support'},{'foreground':'ab2a1d','fontStyle':'italic','token':'invalid.deprecated'},{'foreground':'f8f8f8','background':'9d1e15','token':'invalid.illegal'},{'foreground':'ff6400','fontStyle':'italic','token':'entity.other.inherited-class'},{'foreground':'ff6400','token':'string constant.other.placeholder'},{'foreground':'becde6','token':'meta.function-call.py'},{'foreground':'7f90aa','token':'meta.tag'},{'foreground':'7f90aa','token':'meta.tag entity'},{'foreground':'ffffff','token':'entity.name.section'},{'foreground':'d5e0f3','token':'keyword.type.variant'},{'foreground':'f8f8f8','token':'source.ocaml keyword.operator.symbol'},{'foreground':'8da6ce','token':'source.ocaml keyword.operator.symbol.infix'},{'foreground':'8da6ce','token':'source.ocaml keyword.operator.symbol.prefix'},{'fontStyle':'underline','token':'source.ocaml keyword.operator.symbol.infix.floating-point'},{'fontStyle':'underline','token':'source.ocaml keyword.operator.symbol.prefix.floating-point'},{'fontStyle':'underline','token':'source.ocaml constant.numeric.floating-point'},{'background':'ffffff08','token':'text.tex.latex meta.function.environment'},{'background':'7a96fa08','token':'text.tex.latex meta.function.environment meta.function.environment'},{'foreground':'fbde2d','token':'text.tex.latex support.function'},{'foreground':'ffffff','token':'source.plist string.unquoted'},{'foreground':'ffffff','token':'source.plist keyword.operator'}],'colors':{'editor.foreground':'#F8F8F8','editor.background':'#0C1021','editor.selectionBackground':'#253B76','editor.lineHighlightBackground':'#FFFFFF0F','editorCursor.foreground':'#FFFFFFA6','editorWhitespace.foreground':'#FFFFFF40'}};
                //monaco.editor.defineTheme('blackboard', monacoTheme);
                document.getElementById(monacoId).editor = monaco.editor.create($refs.monacoEditorElement, {
                    value: file_contents,
                    theme: 'blackboard',
                    fontSize: monacoFontSize,
                    lineNumbersMinChars: 3,
                    automaticLayout: true,
                    language: monacoLanguage,
                    minimap: { enabled: false },
                    padding: { top: 10, bottom: 0, left: 0, right: 0 }
                });
                monacoEditor(document.getElementById(monacoId).editor);
                document.getElementById(monacoId).addEventListener('monaco-editor-focused', function(event){
                    document.getElementById(monacoId).editor.focus();
                });
                updatePlaceholder(document.getElementById(monacoId).editor.getValue());
                
            });

            clearInterval(monacoLoaderInterval);
            monacoLoader = false;
        }
    }, 5);
" :id="monacoId" @file-selected.window="setValue($event.detail[0].content);" class="flex flex-col items-center relative justify-start w-full bg-white dark:bg-[#0C1021] min-h-[250px] h-100">
<div x-show="monacoLoader" class="flex absolute inset-0 z-20 justify-center items-center w-full h-full duration-1000 ease-out">
    <svg class="w-4 h-4 text-gray-400 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
</div>

<div x-show="!monacoLoader" class="relative z-10 w-full h-full">
    <div x-ref="monacoEditorElement" class="w-full h-full text-lg"></div>
    <div x-ref="monacoPlaceholderElement" x-show="monacoPlaceholder" @click="monacoEditorFocus()" :style="'font-size: ' + monacoFontSize" class="absolute top-0 left-0 z-50 mt-3 ml-14 w-full font-mono text-sm text-gray-500 -translate-x-0.5" x-text="monacoPlaceholderText"></div>
</div>
</div>