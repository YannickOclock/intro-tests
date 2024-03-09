<script>
    const getPosts = async () => {
        const response = await fetch('/api/posts');

        /**
         * @type {data} response
         * @property {DocumentFragment} posts
         */

        const data = await response.json();
        const posts = data.posts ?? [];
        const template = document.querySelector('template');
        const postsDiv = document.getElementById('posts');
        postsDiv.innerHTML = '';
        posts.forEach(post => {

            /**
             * @type {DocumentFragment} post
             * @property {string} id
             * @property {string} title
             * @property {string} content
             * @property {string} author
             * @property {string} date
             */

            const clone = document.importNode(template.content, true);
            const article = clone.querySelector('article');
            article.dataset.id = post.id;
            article.querySelector('h2').textContent = post.title;
            article.querySelector('p:nth-of-type(1)').textContent = post.content;
            article.querySelector('p:nth-of-type(2)').textContent = post.author;
            article.querySelector('p:nth-of-type(3)').textContent = post.date;
            postsDiv.appendChild(clone);
        });
    }
    getPosts();
</script>

<h1>Posts</h1>
<div id="posts"></div>

<template>
    <article data-id="">
        <h2></h2>
        <p></p>
        <p></p>
        <p></p>
    </article>
</template>