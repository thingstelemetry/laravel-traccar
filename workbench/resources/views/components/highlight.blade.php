@props(['code'])

<div id="pre"></div>

<script type="module">
    import { codeToHtml } from 'https://esm.sh/shiki@3.0.0'

    const pre = document.getElementById('pre')
    const code = JSON.stringify(@json($code), null, 2) // adds indentation

    pre.innerHTML = await codeToHtml(code, {
        lang: 'php',
        theme: 'github-dark'
    })
</script>