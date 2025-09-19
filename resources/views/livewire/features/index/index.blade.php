<div class="w-full h-screen">
    <style>
        .iframe-container {
            width: 100%;
            height: calc(100vh - 4rem); /* Adjust based on your header height */
            border: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            border-radius: 1rem;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
    
    <div class="iframe-container">
        <iframe src="{{ $url }}" 
                title="Embedded Website" 
                allowfullscreen 
                sandbox="allow-same-origin allow-scripts allow-popups allow-forms">
        </iframe>
    </div>
</div>
