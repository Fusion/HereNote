# WHAT IT THIS?

After several years of moving my blog from one engine to another, mostly out of curiosity, sometimes contributing to these engines one way or another (Wordpress plug ins or a teeny Mezzanine add-on), I realized several things:

1. Most blog engines have become too bloated to be... blog engines. IMO.
2. Blog posts now represent a minor percentage of my output. Like everybody else, I post on social networks.
3. Maybe PHP will not burn my fingers if I use it again, albeit in moderation (Yes, I am one of those pedantic language nerds [1])
4. I like Mardkown. Most of the time.  But I like source code syntax highlighting. Most blog engines seem to suffer from variously hilarious side effects when trying to combine syntax highlighting with just about anything else.
5. I am never going to product 10 blog posts/day so I should not be worried too much about scalability.

So, I set up to quickly (#3) put together a small aggregation/blog engine that would pull all my content together (#1, #2) (I am nowhere near done!)

Additionally, both rich text editing and markdown are supported. But not at the same time. This would be madness. Syntax highlighing, however, is also supported. At the same time. Yes. (#4)

I believe that I've created a robust little thing, because 'it is so simple (tm)' and as a result my database is far from optimized and it's OK! (#5) I have time to work on optimizing it, now.

Hope you find this thing useful as well.

# INSTALLING

## Script

Easy way: you have Make installed and can simply run 'make' from the command line.

Less easy way: git clone the repository, pulling dependencies along:

    git clone ...
    git submodule update --init --recursive

Good old way: get this script and all its dependencies by yourself. No fun.

# Database

Either rename `in/dev.db.inc `to `dev.db` and place it where specified in config.php; or import `dev.db.schema.sql`

# INITIALIZING

User management is still very primtive. You will, still, need to create at least one user to author posts/pages: see the file named `create_user_with_password.php.disabled`

This being done, do not forget to edit config.php to your heart's content. Do not change the theme to 'bare' though [2]

# AUTHORING

After signing in (see link in footer?), you will see a tiny '+' menu item. Use it.

All new posts/pages are, by default, in draft form and will only become visible when you change their status to 'published'

# AGGREGATING

The aggregation scripts can be found in the updaters/ directory. So far, only G+ posts and Github issues are retrieved. More to come.

To run these scripts, from the command line execute, for instance, `./updates/g+.php` 

You can run them as many times as you wish, they are supposed to be idempotent (i.e. posts will only be added once)

If you wish to hide a post, do not delete it as it would be synchronized again next time you run a script. Instead, change its status to 'unpublished/draft'

# ACKNOWLEDGMENTS

* Quilljs: it is not the savior of all things WYSIWYG, as I've read lately, but it sure helps. Adding multi lines formats seems nightmarish, though.
* Epiceditor: lightweight, good markdown support. What more can I ask for?
* Parsedown: a fast PHP markdown parser
* highlight.js: a fast Javascript syntax highlighter
* The Modern Wordpress theme, which I shamelessly pilfered.

# FOOTNOTES

1. Cf. the funny "Brief, Incomplete, and Mostly Wrong History of Programming Languages" quote: "LISP (now "Lisp" or sometimes "Arc") remains an influential language in "key algorithmic techniques such as recursion and condescension"
2. I started work using a copy of my old blog's theme, 'bare', but quickly switched to 'modern' and of course forgot to update 'bare' as I was switching to "proper" templating, etc.
