import Viewer from 'viewerjs'

const gallery = new Viewer(document.getElementById('gallery'), {
    'button': false,
    'title': false,
    toolbar: {
        zoomIn: 4,
        zoomOut: 4,
        oneToOne: 0,
        reset: 0,
        prev: 4,
        play: {
            show: 0,
        },
        next: 4,
        rotateLeft: 0,
        rotateRight: 0,
        flipHorizontal: 0,
        flipVertical: 0,
    },
});

