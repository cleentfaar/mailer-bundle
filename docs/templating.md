# Templating (using the provided layout)

Templating is part of the Mailer library itself, but here are some useful tips 
for working within a Symfony project.

Depending on the templating engine you are using (PHP or Twig), you can use
the layout provided by the Mailer library, as described in [it's documentation](http://symfony.com/doc/current/components/templating.html).

However, since we are working *within* a Symfony project here, we need to tell Twig
about the directory where the layout-file is located. This is done in your configuration:

```yaml
# app/config/config.yml
twig:
    # ...
    paths:
        '%kernel.root_dir%/../vendor/cleentfaar/mailer/templates': 'mailer'
```

Now, in your templates, you can refer to the layout like this:

```twig
{% extends '@mailer/layout.html.twig' %}

{% block content %}
  <h1>A header</h1>
  <p>A paragraph with <strong>bold</strong> and <em>italic</em> text</p>
  <p>{{ 'demo.texts.some_random_text'|trans({}, 'mail') }}</p>
  <p>Another paragraph with a link to <a href="https://google.com">Google</a>.</p>
{% endblock %}

```
