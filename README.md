# Stats plugin for CakePHP3

Simple plugin to count things. Just increases/decreases a counter, don't think
about it as a magic statistics plugin.

## Usage

For now, this plugin includes an `increase` and `decrease` methods on `StatsTable`
that you can easily use with the `StatsComponent` (from controllers):

~~~php
$this->Stats->increase('Signup');
~~~


## Patches & Features

* Fork
* Mod, fix
* Test - this is important, so it's not unintentionally broken
* Commit - do not mess with license, todo, version, etc. (if you do change any, bump them into commits of
their own that I can ignore when I pull)
* Pull request - bonus point for topic branches

To ensure your PRs are considered for upstream, you MUST follow the [CakePHP coding standards][standards].

## Bugs & Feedback

See the [github issues][issues].

## License

Copyright (c) 2016, [Cirici New Media][cirici] and licensed under [GPL v3][gpl].

[cakephp]: http://cakephp.org
[composer]: http://getcomposer.org
[issues]: https://github.com/ciricihq/cake-stats/issues
[gpl]: http://www.gnu.org/licenses/gpl-3.0.html
[cirici]: http://www.cirici.com
[standards]: http://book.cakephp.org/3.0/en/contributing/cakephp-coding-conventions.html
