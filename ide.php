<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <meta name="description" content="Free and open-source online code editor that allows you to write and execute code from a rich set of languages.">
    <meta name="keywords" content="online editor, online code editor, online ide, online compiler, online interpreter, run code online, learn programming online,
            online debugger, programming in browser, online code runner, online code execution, debug online, debug C code online, debug C++ code online,
            programming online, snippet, snippets, code snippet, code snippets, pastebin, execute code, programming in browser, run c online, run C++ online,
            run java online, run python online, run ruby online, run c# online, run rust online, run pascal online, run basic online">
    <meta name="author" content="Herman Zvonimir Došilović">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="Judge0 IDE - Free and open-source online code editor">
    <meta property="og:description" content="Free and open-source online code editor that allows you to write and execute code from a rich set of languages.">
    <meta property="og:image" content="https://raw.githubusercontent.com/judge0/ide/master/.github/wallpaper.png">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/golden-layout/1.5.9/goldenlayout.min.js" integrity="sha256-NhJAZDfGgv4PiB+GVlSrPdh3uc75XXYSM4su8hgTchI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/golden-layout/1.5.9/css/goldenlayout-base.css" integrity="sha256-oIDR18yKFZtfjCJfDsJYpTBv1S9QmxYopeqw2dO96xM=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/golden-layout/1.5.9/css/goldenlayout-dark-theme.css" integrity="sha256-ygw8PvSDJJUGLf6Q9KIQsYR3mOmiQNlDaxMLDOx9xL0=" crossorigin="anonymous" />

    <script>
        var require = {
            paths: {
                "vs": "https://unpkg.com/monaco-editor/min/vs",
                "monaco-vim": "https://unpkg.com/monaco-vim/dist/monaco-vim",
                "monaco-emacs": "https://unpkg.com/monaco-emacs/dist/monaco-emacs"
            }
        };
    </script>
    <script src="https://unpkg.com/monaco-editor/min/vs/loader.js"></script>
    <script src="https://unpkg.com/monaco-editor@0.18.1/min/vs/editor/editor.main.nls.js"></script>
    <script src="https://unpkg.com/monaco-editor@0.18.1/min/vs/editor/editor.main.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" integrity="sha256-9mbkOfVho3ZPXfM7W8sV2SndrGDuh7wuyLjtsWeTI1Q=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha256-t8GepnyPmw9t+foMh3mKNvcorqNHamSKtKRxxpUEgFI=" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">

    <script type="text/javascript" src="third_party/download.js"></script>

    <script type="text/javascript" src="assets/js/ide.js"></script>

    <link type="text/css" rel="stylesheet" href="assets/css/ide.css">

    <title>Judge0 IDE - Free and open-source online code editor</title>
    <!-- <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"> -->
    <!-- <link rel="icon" href="./favicon.ico" type="image/x-icon"> -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83802640-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-83802640-2');
    </script>

    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="ee4621ff-c682-44ac-8cfa-1835beddb98a";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
</head>

<body>
    <div id="site-navigation" class="ui small inverted menu">
        <div class="left menu">
            <div class="ui dropdown item site-links on-hover">
                <div class="menu">for current language</div>
            </div>
        </div>
        <div class="item borderless">
            <select id="select-language" class="ui dropdown">
                <option value="49" mode="c">C (GCC 8.3.0)</option>
                <option value="52" mode="cpp">C++ (GCC 7.4.0)</option>
                <option value="62" mode="java">Java (OpenJDK 13.0.1)</option>
            </select>
        </div>
        <div class="item fitted borderless">
            <!-- <div class="ui input"> -->
                <!-- <input id="compiler-options" type="text" placeholder="Compiler options" style="display: none !important"> -->
                <!-- <button>Submit</button>
 -->            <!-- </div> -->
        </div>
        <div class="item fitted borderless wide screen only">
            <!-- <div class="ui input"> -->
                <input id="compiler-options" type="text" placeholder="Compiler options" style="display: none !important">
                <!-- <button>Submit</button> -->
            <!-- </div> -->
        </div>
        <div class="item borderless wide screen only">
            <!-- <div class="ui input"> -->
                <input id="command-line-arguments" type="text" placeholder="Command line arguments" style="display: none !important">
            <!-- </div> -->
        </div>
        <div class="item no-left-padding borderless">
            <button id="run-btn" class="ui primary labeled icon button"><i class="play icon"></i>Run (F9)</button>
            <button class="ui primary button btn-danger" style="margin-left: 5px; padding: 10px 30px 10px 30px; background-color: #d9534f;">Submit</button>
        </div>
    </div>
    <!-- </div> -->

    <div id="site-content"></div>

    <div id="site-footer">
        <span id="donate-line">
        </span>
        <div id="editor-status-line"></div>
    </div>
    <script>
        let CLF_config = {
            selector: ".changelogfy-widget",
            app_id: "f6f982d0-3d91-4b1c-a3ce-b0eb54606c4e"
        };
    </script>
    <script async src="https://widget.changelogfy.com/index.js"></script>
    <script type="text/javascript">
        $("lm_splitter, .lm_horizontal").css("display": "none !important");
        $(".lm_horizontal").css("display": "none");
        $(".lm_item, .lm_column").css("display": "none !important");
        $("span.cc-7doi").css("display": "none");
        console.log($("span.cc-7doi"));
        console.log("Hi1");
        $(".lm_splitter, .lm_horizontal").css("left", "30px");
    </script>
</body>

</html>
