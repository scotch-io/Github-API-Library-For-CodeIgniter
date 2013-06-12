Github-API-Library-For-CodeIgniter
===================================

Simple Github library for CodeIgniter. Supports GitHub OAuth API and all the other cool little functions and calls they have.

## [View the Live Demo](http://github-api-library-for-codeigniter.scotch.io)
## [Learn More](http://scotch.io/bar-talk/x/announcing-github-api-library-for-codeigniter)

![CodeIgniter Github](http://scotch.io/images/github-codeigniter.png "CodeIgniter Github")

## What is this?

It's an out of the box starter for using OAuth and GitHub. It uses the latest version of Codeigniter and has a running demo so all you have to do is set your config keys and you're done. It's one of my last CodeIgniter projects that I want to open-source before embracing the Laravel world entirely.

## Quick Start

- Clone this repo
- Create a GitHub Application on GitHub.com
- Update `/application/config/github.php`

## Are all these files required?

No. There's a lot of stuff that this comes with. You don't need most of these files to get started. For example, I use [Stencil Codeigniter Template Library](http://github.com/scotch-io/stencil) to do the templating. You don't have to do that.

### Requried Files:

 - /application/config/github.php
 - /applicaiton/library/Github.php
 - /application/controllers/authorize.php (not technically necessary, but might as well use it since it's already built for you)


## Basics of how everything works

First, autoload the config and the library, then set your config settings.

### Determine if a User is Logged In

This library determines if you are logged in if you have a GitHub Access Token or not. To see if you are logged in or not just call the function:

> `$this->github->get_access_token()`

This will return FALSE if the user is not logged in. If the user isn't logged in, you'll need to log them in!


### Log in a user

You need to send them to the GitHub login URL. You can do this by having them click there via an `<a>` tag or just by redirecting them. This is how you get the login URL:

> `$this->github->get_login_url();`

That's it! Make sure that wherever your redirect uri config option is set has this function in it receiving it:

> `$this->github->authorize();`

This function pretty much does everything for you -- checking all sorts of OAuth verification checks. If the function returns FALSE, the login failed. You get any error messages like this:

> `$this->github->get_error();`

See the `authorize` controller to understand better how it works. Invoking this method will also work for any other times an error needs to be caught.

### Getting Data -- curl(), the super REST function

This function is intended to make all GitHub REST API calls. This is how it is broken down:

> `public function curl($uri, $verb = 'GET', $body = array(), $headers = FALSE);`

So whenever you call this function, it will automatically build a URL with the access token based on the arguments you submit.

For example, if you want to get list your gists, it will look like this:

> `$this->github->curl('gists');`

Simple. if you need to do something more complicated it could look like this:

> `$this->github->curl('gists/'.$id, 'PATCH', $body);`

It can even return HTTP Codes (perfect for REST). It would look something like this:

> `$this->github->curl('gists/'.$id.'/star', 'GET', '', TRUE);`

## Notes / To-Dos
 - Throw Errors for try/catch versus returning FALSE all the time