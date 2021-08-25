<template>
    <div id="comments-viewer" v-show="show">
        <div class="dialog-box">
            <h3 class="dialog-title" ref="dialog-title">{{ title }}</h3>
            <a class="dialog-close" title="Close" @click="onCloseClick">&times;</a>
            <div class="dialog-content">
                <div v-if="!comments.length">No comments yet ...</div>
                <comment
                    v-else
                    v-for="comment in comments"
                    :key="comment.id"
                    :content="comment.content"
                    :author="comment.author"
                >
                </comment>
            </div>
            <div class="dialog-action">
                <input type="text" v-model="comment" placeholder="Type a comment">
                <button type="button" @click="onCommentSubmit">Submit</button>
                <br>
                <span
                    v-if="contentErrorMessage.length"
                    class="error"
                    id="content-error"
                >
                    {{ contentErrorMessage }}
                </span>
            </div>
        </div>
        <div class="dialog-box-overlay"></div>
    </div>
</template>

<script>
import Comment from "./Comment";

export default {
    name: "CommentsViewer",
    components: { Comment },
    props: ['show', 'comments', 'title', 'postId'],
    data() {
        return {
            comment: '',
            loading: false,
            contentErrorMessage: ''
        }
    },
    methods: {
        setDialog() {
            let selected = null,
                xPos = 0,
                yPos = 0,
                xElem = 0,
                yElem = 0

            function dragInit(elem) {
                selected = elem
                xElem = xPos - selected.offsetLeft
                yElem = yPos - selected.offsetTop
            }

            function moveElem(e) {
                xPos = document.all ? window.event.clientX : e.pageX
                yPos = document.all ? window.event.clientY : e.pageY

                if (selected !== null) {
                    selected.style.left = ((xPos - xElem) + selected.offsetWidth / 2) + 'px'
                    selected.style.top = ((yPos - yElem) + selected.offsetHeight / 2) + 'px'
                }
            }

            function _destroy() {
                selected = null
            }

            this.$refs['dialog-title'].onmousedown = () => {
                dragInit(this.$refs['dialog-title'].parentNode)
                return false
            }

            document.onmousemove = moveElem
            document.onmouseup = _destroy
        },
        onCloseClick() {
            this.$emit('comments-viewer:close')
        },
        validateComment() {
            this.comment = this.comment.trim()

            let validated = Boolean(this.comment.length)

            if (validated) {
                this.contentErrorMessage = ''
            } else {
                this.contentErrorMessage = 'This field must not be empty'
            }

            return validated
        },
        onCommentSubmit() {
            if (!this.validateComment()) {
                return
            }

            let payload = { content: this.comment, postId: this.postId }

            this.loading = true
            axios.post('/home/comment', payload)
                .then((res) => {
                    if (res.data.comments) {
                        this.$emit('comments-viewer:comments-updated', res.data.comments)
                    }

                    // Clear input
                    this.comment = ''
                })
                .catch((err) => {
                    console.error(err)

                    if (err.errors && err.errors.content && err.errors.content.length) {
                        this.contentErrorMessage = err.errors.content[0]
                    } else {
                        this.contentErrorMessage = ''
                    }
                })
                .finally(() => this.loading = false)
        },
    },
    mounted() {
        this.setDialog()
    },
}
</script>

<style scoped>
.dialog-box {
    width: 30%;
    height: 70%;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 1px 5px rgba(0, 0, 0, .2);
    position: fixed;
    z-index: 9999;
    color: #666;
    /* TODO: there's got to be a better way to do this */
    margin-top: -210px;
    margin-left: -210px;
    left: 50%;
    top: 50%;
}

.dialog-box .dialog-title {
    margin: 0;
    font: inherit;
    color: inherit;
    font-weight: bold;
    height: 2em;
    line-height: 2em;
    overflow: hidden;
    padding: 0 .8em;
    background-color: #eee;
    cursor: move;
}

.dialog-box .dialog-content {
    border-top: 1px solid #ccc;
    padding: 1em;
    position: absolute;
    top: 2em;
    right: 0;
    bottom: 3em;
    left: 0;
    overflow: auto;
}

.dialog-box .dialog-content iframe {
    display: block;
    border: none;
    background: none;
    margin: 0;
    padding: 0;
    overflow: auto;
    width: 100%;
    height: 100%;
}

.dialog-box .dialog-action {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    height: 2em;
    padding: .5em;
    background-color: #eee;
    border-top: 1px solid #ccc;
    text-align: right;
}

.dialog-box .dialog-action .btn {
    text-decoration: none;
    outline: none;
    color: inherit;
    font-weight: bold;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: .2em;
    padding: .4em 1em;
    margin-left: .2em;
    line-height: 2em;
    cursor: pointer;
}

.dialog-box .dialog-close, .dialog-box .dialog-minmax {
    border: none;
    outline: none;
    background: none;
    font: inherit;
    font-family: Arial, SansSerif;
    font-style: normal;
    font-weight: bold;
    font-size: 150%;
    line-height: 1.4em;
    color: #aaa;
    text-decoration: none;
    position: absolute;
    top: 0;
    right: .3em;
    text-align: center;
    cursor: pointer;
}

.dialog-box .dialog-minmax {
    right: 1.5em;
}

.dialog-box .dialog-close:focus,
.dialog-box .dialog-minmax:focus,
.dialog-box .dialog-action .btn:focus {
    border-width: 0;
    outline: none;
}

.dialog-box .dialog-close:hover, .dialog-box .dialog-minmax:hover {
    color: #777;
}

.dialog-box .dialog-close:focus, .dialog-box .dialog-minmax:focus {
    color: #c90000;
}

.dialog-box .dialog-close:active, .dialog-box .dialog-minmax:active {
    color: #444;
}

.dialog-box + .dialog-box-overlay {
    background-color: black;
    opacity: .2;
    filter: alpha(opacity=20);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 9997;
}

#content-error {
    font-size: 16px;
}
</style>
