<?php $GLOBALS['__jpv_dotWithArrayPrototype'] = function ($base) {
    $arrayPrototype = function ($base, $key) {
        if ($key === 'length') {
            return count($base);
        }
        if ($key === 'forEach') {
            return function ($callback, $userData = null) use (&$base) {
                return array_walk($base, $callback, $userData);
            };
        }
        if ($key === 'map') {
            return function ($callback) use (&$base) {
                return array_map($callback, $base);
            };
        }
        if ($key === 'filter') {
            return function ($callback, $flag = 0) use ($base) {
                return func_num_args() === 1 ? array_filter($base, $callback) : array_filter($base, $callback, $flag);
            };
        }
        if ($key === 'pop') {
            return function () use (&$base) {
                return array_pop($base);
            };
        }
        if ($key === 'shift') {
            return function () use (&$base) {
                return array_shift($base);
            };
        }
        if ($key === 'push') {
            return function ($item) use (&$base) {
                return array_push($base, $item);
            };
        }
        if ($key === 'unshift') {
            return function ($item) use (&$base) {
                return array_unshift($base, $item);
            };
        }
        if ($key === 'indexOf') {
            return function ($item) use (&$base) {
                $search = array_search($item, $base);

                return $search === false ? -1 : $search;
            };
        }
        if ($key === 'slice') {
            return function ($offset, $length = null, $preserveKeys = false) use (&$base) {
                return array_slice($base, $offset, $length, $preserveKeys);
            };
        }
        if ($key === 'splice') {
            return function ($offset, $length = null, $replacements = array()) use (&$base) {
                return array_splice($base, $offset, $length, $replacements);
            };
        }
        if ($key === 'reverse') {
            return function () use (&$base) {
                return array_reverse($base);
            };
        }
        if ($key === 'reduce') {
            return function ($callback, $initial = null) use (&$base) {
                return array_reduce($base, $callback, $initial);
            };
        }
        if ($key === 'join') {
            return function ($glue) use (&$base) {
                return implode($glue, $base);
            };
        }
        if ($key === 'sort') {
            return function ($callback = null) use (&$base) {
                return $callback ? usort($base, $callback) : sort($base);
            };
        }

        return null;
    };
    $getFromArray = function ($base, $key) use ($arrayPrototype) {
        return isset($base[$key])
            ? $base[$key]
            : $arrayPrototype($base, $key);
    };
    $getCallable = function ($base, $key) use ($getFromArray) {
        if (is_callable(array($base, $key))) {
            return array($base, $key);
        }
        if ($base instanceof \ArrayAccess) {
            return $getFromArray($base, $key);
        }
    };
    $getRegExp = function ($value) {
        return isset($value->isRegularExpression) && $value->isRegularExpression ? $value->regExp : null;
    };
    $fallbackDot = function ($base, $key) use ($getCallable, $getRegExp) {
        if (is_string($base)) {
            if (preg_match('/^[-+]?\d+$/', strval($key))) {
                return substr($base, intval($key), 1);
            }
            if ($key === 'length') {
                return strlen($base);
            }
            if ($key === 'substr' || $key === 'slice') {
                return function ($start, $length = null) use ($base) {
                    return func_num_args() === 1 ? substr($base, $start) : substr($base, $start, $length);
                };
            }
            if ($key === 'charAt') {
                return function ($pos) use ($base) {
                    return substr($base, $pos, 1);
                };
            }
            if ($key === 'indexOf') {
                return function ($needle) use ($base) {
                    $pos = strpos($base, $needle);

                    return $pos === false ? -1 : $pos;
                };
            }
            if ($key === 'toUpperCase') {
                return function () use ($base) {
                    return strtoupper($base);
                };
            }
            if ($key === 'toLowerCase') {
                return function () use ($base) {
                    return strtolower($base);
                };
            }
            if ($key === 'match') {
                return function ($search) use ($base, $getRegExp) {
                    if (!$getRegExp($search)) {
                        $search = '/' . preg_quote($search) . '/';
                    }

                    return preg_match($search, $base);
                };
            }
            if ($key === 'split') {
                return function ($delimiter) use ($base, $getRegExp) {
                    if ($regExp = $getRegExp($delimiter)) {
                        return preg_split($regExp, $base);
                    }

                    return explode($delimiter, $base);
                };
            }
            if ($key === 'replace') {
                return function ($from, $to) use ($base, $getRegExp) {
                    if ($regExp = $getRegExp($from)) {
                        return preg_replace($regExp, $to, $base);
                    }

                    return str_replace($from, $to, $base);
                };
            }
        }

        return $getCallable($base, $key);
    };
    foreach (array_slice(func_get_args(), 1) as $key) {
        $base = is_array($base)
            ? $getFromArray($base, $key)
            : (is_object($base)
                ? (isset($base->$key)
                    ? $base->$key
                    : (method_exists($base, $method = "get" . ucfirst($key))
                        ? $base->$method()
                        : (method_exists($base, $key)
                            ? array($base, $key)
                            : $getCallable($base, $key)
                        )
                    )
                )
                : $fallbackDot($base, $key)
            );
    }

    return $base;
};
$GLOBALS['__jpv_plus'] = function ($base) {
    foreach (array_slice(func_get_args(), 1) as $value) {
        $base = is_string($base) || is_string($value) ? $base . $value : $base + $value;
    }

    return $base;
};
 ?><?php
$pug_vars = [];
foreach (array_keys(get_defined_vars()) as $__pug_key) {
    $pug_vars[$__pug_key] = &$$__pug_key;
}
?><?php $pugModule = [
  'Phug\\Formatter\\Format\\BasicFormat::dependencies_storage' => 'pugModule',
  'Phug\\Formatter\\Format\\BasicFormat::helper_prefix' => 'Phug\\Formatter\\Format\\BasicFormat::',
  'Phug\\Formatter\\Format\\BasicFormat::get_helper' => function ($name) use (&$pugModule) {
    $dependenciesStorage = $pugModule['Phug\\Formatter\\Format\\BasicFormat::dependencies_storage'];
    $prefix = $pugModule['Phug\\Formatter\\Format\\BasicFormat::helper_prefix'];
    $format = $pugModule['Phug\\Formatter\\Format\\BasicFormat::dependencies_storage'];

                            if (!isset($$dependenciesStorage)) {
                                return $format->getHelper($name);
                            }

                            $storage = $$dependenciesStorage;

                            if (!array_key_exists($prefix.$name, $storage) &&
                                !isset($storage[$prefix.$name])
                            ) {
                                throw new \Exception(
                                    var_export($name, true).
                                    ' dependency not found in the namespace: '.
                                    var_export($prefix, true)
                                );
                            }

                            return $storage[$prefix.$name];
                        },
  'Phug\\Formatter\\Format\\BasicFormat::pattern' => function ($pattern) use (&$pugModule) {

                    $args = func_get_args();
                    $function = 'sprintf';
                    if (is_callable($pattern)) {
                        $function = $pattern;
                        $args = array_slice($args, 1);
                    }

                    return call_user_func_array($function, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::patterns.html_text_escape' => 'htmlspecialchars',
  'Phug\\Formatter\\Format\\BasicFormat::pattern.html_text_escape' => function () use (&$pugModule) {
    $proceed = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::patterns.html_text_escape'];

                    $args = func_get_args();
                    array_unshift($args, $pattern);

                    return call_user_func_array($proceed, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::available_attribute_assignments' => array (
  0 => 'class',
  1 => 'style',
),
  'Phug\\Formatter\\Format\\BasicFormat::patterns.attribute_pattern' => ' %s="%s"',
  'Phug\\Formatter\\Format\\BasicFormat::pattern.attribute_pattern' => function () use (&$pugModule) {
    $proceed = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::patterns.attribute_pattern'];

                    $args = func_get_args();
                    array_unshift($args, $pattern);

                    return call_user_func_array($proceed, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::patterns.boolean_attribute_pattern' => ' %s="%s"',
  'Phug\\Formatter\\Format\\BasicFormat::pattern.boolean_attribute_pattern' => function () use (&$pugModule) {
    $proceed = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::patterns.boolean_attribute_pattern'];

                    $args = func_get_args();
                    array_unshift($args, $pattern);

                    return call_user_func_array($proceed, $args);
                },
  'Phug\\Formatter\\Format\\BasicFormat::attribute_assignments' => function (&$attributes, $name, $value) use (&$pugModule) {
    $availableAssignments = $pugModule['Phug\\Formatter\\Format\\BasicFormat::available_attribute_assignments'];
    $getHelper = $pugModule['Phug\\Formatter\\Format\\BasicFormat::get_helper'];

                    if (!in_array($name, $availableAssignments)) {
                        return $value;
                    }

                    $helper = $getHelper($name.'_attribute_assignment');

                    return $helper($attributes, $value);
                },
  'Phug\\Formatter\\Format\\BasicFormat::attribute_assignment' => function (&$attributes, $name, $value) use (&$pugModule) {
    $attributeAssignments = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attribute_assignments'];

                    if (isset($name) && $name !== '') {
                        $result = $attributeAssignments($attributes, $name, $value);
                        if (($result !== null && $result !== false && ($result !== '' || $name !== 'class'))) {
                            $attributes[$name] = $result;
                        }
                    }
                },
  'Phug\\Formatter\\Format\\BasicFormat::merge_attributes' => function () use (&$pugModule) {
    $attributeAssignment = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attribute_assignment'];

                    $attributes = [];
                    foreach (array_filter(func_get_args(), 'is_array') as $input) {
                        foreach ($input as $name => $value) {
                            $attributeAssignment($attributes, $name, $value);
                        }
                    }

                    return $attributes;
                },
  'Phug\\Formatter\\Format\\BasicFormat::array_escape' => function ($name, $input) use (&$pugModule) {
    $arrayEscape = $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'];
    $escape = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern.html_text_escape'];

                        if (is_array($input) && in_array(strtolower($name), ['class', 'style'])) {
                            $result = [];
                            foreach ($input as $key => $value) {
                                $result[$escape($key)] = $arrayEscape($name, $value);
                            }

                            return $result;
                        }
                        if (is_array($input) || is_object($input) && !method_exists($input, '__toString')) {
                            return $escape(json_encode($input));
                        }
                        if (is_string($input)) {
                            return $escape($input);
                        }

                        return $input;
                    },
  'Phug\\Formatter\\Format\\BasicFormat::attributes_mapping' => array (
),
  'Phug\\Formatter\\Format\\BasicFormat::attributes_assignment' => function () use (&$pugModule) {
    $attrMapping = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_mapping'];
    $mergeAttr = $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'];
    $pattern = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern'];
    $escape = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern.html_text_escape'];
    $attr = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern.attribute_pattern'];
    $bool = $pugModule['Phug\\Formatter\\Format\\BasicFormat::pattern.boolean_attribute_pattern'];

                        $attributes = call_user_func_array($mergeAttr, func_get_args());
                        $code = '';
                        foreach ($attributes as $originalName => $value) {
                            if ($value !== null && $value !== false && ($value !== '' || $originalName !== 'class')) {
                                $name = isset($attrMapping[$originalName])
                                    ? $attrMapping[$originalName]
                                    : $originalName;
                                if ($value === true) {
                                    $code .= $pattern($bool, $name, $name);

                                    continue;
                                }
                                if (is_array($value) || is_object($value) &&
                                    !method_exists($value, '__toString')) {
                                    $value = json_encode($value);
                                }

                                $code .= $pattern($attr, $name, $value);
                            }
                        }

                        return $code;
                    },
  'Phug\\Formatter\\Format\\BasicFormat::class_attribute_assignment' => function (&$attributes, $value) use (&$pugModule) {

            $split = function ($input) {
                return preg_split('/(?<![\[\{\<\=\%])\s+(?![\]\}\>\=\%])/', strval($input));
            };
            $classes = isset($attributes['class']) ? array_filter($split($attributes['class'])) : [];
            foreach ((array) $value as $key => $input) {
                if (!is_string($input) && is_string($key)) {
                    if (!$input) {
                        continue;
                    }

                    $input = $key;
                }
                foreach ($split($input) as $class) {
                    if (!in_array($class, $classes)) {
                        $classes[] = $class;
                    }
                }
            }

            return implode(' ', $classes);
        },
  'Phug\\Formatter\\Format\\BasicFormat::style_attribute_assignment' => function (&$attributes, $value) use (&$pugModule) {

            if (is_string($value) && mb_substr($value, 0, 7) === '{&quot;') {
                $value = json_decode(htmlspecialchars_decode($value));
            }
            $styles = isset($attributes['style']) ? array_filter(explode(';', $attributes['style'])) : [];
            foreach ((array) $value as $propertyName => $propertyValue) {
                if (!is_int($propertyName)) {
                    $propertyValue = $propertyName.':'.$propertyValue;
                }
                $styles[] = $propertyValue;
            }

            return implode(';', $styles);
        },
]; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['breadcrumbs'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'links', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(4);
// PUG_DEBUG:4
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'breadcrumbs'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(3);
// PUG_DEBUG:3
 ?><?php foreach ($links as $link) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(2);
// PUG_DEBUG:2
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'breadcrumbs__link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($link) ? $link : null), 'href'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(0);
// PUG_DEBUG:0
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($link) ? $link : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1);
// PUG_DEBUG:1
 ?></a><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['btn'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'tag', null], [false, 'text', null], [false, 'className', null], [false, 'disabled', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(10);
// PUG_DEBUG:10
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(9);
// PUG_DEBUG:9
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(6);
// PUG_DEBUG:6
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(8);
// PUG_DEBUG:8
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(7);
// PUG_DEBUG:7
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(15);
// PUG_DEBUG:15
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(14);
// PUG_DEBUG:14
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(11);
// PUG_DEBUG:11
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(13);
// PUG_DEBUG:13
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(12);
// PUG_DEBUG:12
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(20);
// PUG_DEBUG:20
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(16);
// PUG_DEBUG:16
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(18);
// PUG_DEBUG:18
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(17);
// PUG_DEBUG:17
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(19);
// PUG_DEBUG:19
 ?></a><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['text'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(24);
// PUG_DEBUG:24
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(22);
// PUG_DEBUG:22
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(23);
// PUG_DEBUG:23
 ?></p><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['animation-fade'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'duration', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(27);
// PUG_DEBUG:27
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(26);
// PUG_DEBUG:26
 ?></transition><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['detail-nav'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'nav', null], [false, 'className', null], [false, 'offersAnchor', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(45);
// PUG_DEBUG:45
 ?><?php $fixHeader = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(46);
// PUG_DEBUG:46
 ?><?php $activeAnchor = '' ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(67);
// PUG_DEBUG:67
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-nav'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), (isset($fixHeader) ? $fixHeader : null) ? 'detail-nav--fixed' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(66);
// PUG_DEBUG:66
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'], ['class' => 'detail-nav__main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(58);
// PUG_DEBUG:58
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($nav) ? $nav : null), 'title'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(57);
// PUG_DEBUG:57
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-nav__info-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(53);
// PUG_DEBUG:53
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-nav__info'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(48);
// PUG_DEBUG:48
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-nav__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(47);
// PUG_DEBUG:47
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($nav) ? $nav : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(51);
// PUG_DEBUG:51
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($nav) ? $nav : null), 'price'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(50);
// PUG_DEBUG:50
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-nav__price'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(49);
// PUG_DEBUG:49
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($nav) ? $nav : null), 'price')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(52);
// PUG_DEBUG:52
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(55);
// PUG_DEBUG:55
 ?><?php if (((isset($offersAnchor) ? $offersAnchor : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(54);
// PUG_DEBUG:54
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'btn';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@click' => 'scrollTo(offersAnchor)']), [[false, 'button'], [false, 'Планировки и цены'], [false, 'btn--border detail-nav__button']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(56);
// PUG_DEBUG:56
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'btn';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@click' => 'openPopup']), [[false, 'button'], [false, 'Записаться на просмотр'], [false, 'btn--border detail-nav__button']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(59);
// PUG_DEBUG:59
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(64);
// PUG_DEBUG:64
 }  if ((isset($nav) ? $nav : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(63);
// PUG_DEBUG:63
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-nav__links'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($nav) ? $nav : null), 'title') ? '' : 'detail-nav__links--big'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(62);
// PUG_DEBUG:62
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $nav, 'links') as $btn) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(61);
// PUG_DEBUG:61
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-nav__link'], ['@click' => 'scrollTo(btn.anchor)'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', ((isset($activeAnchor) ? $activeAnchor : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'anchor') ? 'detail-nav__link--active' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(60);
// PUG_DEBUG:60
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(65);
// PUG_DEBUG:65
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['picture'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'data', null], [false, 'className', null], [false, 'optimize', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(89);
// PUG_DEBUG:89
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(88);
// PUG_DEBUG:88
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(77);
// PUG_DEBUG:77
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(76);
// PUG_DEBUG:76
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(75);
// PUG_DEBUG:75
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(78);
// PUG_DEBUG:78
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(81);
// PUG_DEBUG:81
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(80);
// PUG_DEBUG:80
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(79);
// PUG_DEBUG:79
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(82);
// PUG_DEBUG:82
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(85);
// PUG_DEBUG:85
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(84);
// PUG_DEBUG:84
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(83);
// PUG_DEBUG:83
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(86);
// PUG_DEBUG:86
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(87);
// PUG_DEBUG:87
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(104);
// PUG_DEBUG:104
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(92);
// PUG_DEBUG:92
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(91);
// PUG_DEBUG:91
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(90);
// PUG_DEBUG:90
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(93);
// PUG_DEBUG:93
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(96);
// PUG_DEBUG:96
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(95);
// PUG_DEBUG:95
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(94);
// PUG_DEBUG:94
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(97);
// PUG_DEBUG:97
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(100);
// PUG_DEBUG:100
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(99);
// PUG_DEBUG:99
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(98);
// PUG_DEBUG:98
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(101);
// PUG_DEBUG:101
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(102);
// PUG_DEBUG:102
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(103);
// PUG_DEBUG:103
 ?></picture><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['detail-district-main'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(145);
// PUG_DEBUG:145
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main'], ['id' => 'main'], ['data-screen' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(126);
// PUG_DEBUG:126
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'picture';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'image')], [false, 'detail-district-main__bg']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(144);
// PUG_DEBUG:144
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(127);
// PUG_DEBUG:127
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'breadcrumbs';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'breadcrumbs')], [false, 'breadcrumbs--white detail-district-main__breadcrumbs']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(143);
// PUG_DEBUG:143
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(133);
// PUG_DEBUG:133
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(129);
// PUG_DEBUG:129
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(128);
// PUG_DEBUG:128
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(131);
// PUG_DEBUG:131
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__subtitle'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(130);
// PUG_DEBUG:130
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'subtitle')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(132);
// PUG_DEBUG:132
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'btn';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@click' => 'scrollTo(&quot;#offers&quot;)']), [[false, 'button'], [false, 'Предложения в районе'], [false, 'detail-district-main__button']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(141);
// PUG_DEBUG:141
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'info'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(140);
// PUG_DEBUG:140
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__info'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(139);
// PUG_DEBUG:139
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'info') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(138);
// PUG_DEBUG:138
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__info-item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(135);
// PUG_DEBUG:135
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__info-icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(134);
// PUG_DEBUG:134
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'icon'))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(137);
// PUG_DEBUG:137
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-main__info-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(136);
// PUG_DEBUG:136
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(142);
// PUG_DEBUG:142
 ?><!----><?php } ?></div></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null], [false, 'link', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(149);
// PUG_DEBUG:149
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(148);
// PUG_DEBUG:148
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(147);
// PUG_DEBUG:147
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(152);
// PUG_DEBUG:152
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(150);
// PUG_DEBUG:150
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(151);
// PUG_DEBUG:151
 ?></div><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['detail-district-about'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(176);
// PUG_DEBUG:176
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about'], ['id' => 'about'], ['data-screen' => 'about'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(175);
// PUG_DEBUG:175
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(158);
// PUG_DEBUG:158
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'title';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')], [false, 'detail-district-about__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(174);
// PUG_DEBUG:174
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about__wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(164);
// PUG_DEBUG:164
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about__main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(162);
// PUG_DEBUG:162
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'text'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(161);
// PUG_DEBUG:161
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(160);
// PUG_DEBUG:160
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'text') as $text) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(159);
// PUG_DEBUG:159
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'text';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($text) ? $text : null)], [false, 'detail-district-about__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(163);
// PUG_DEBUG:163
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(172);
// PUG_DEBUG:172
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'info'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(171);
// PUG_DEBUG:171
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about__info'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(170);
// PUG_DEBUG:170
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'info') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(169);
// PUG_DEBUG:169
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about__item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(166);
// PUG_DEBUG:166
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about__item-num'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(165);
// PUG_DEBUG:165
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(168);
// PUG_DEBUG:168
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district-about__item-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(167);
// PUG_DEBUG:167
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(173);
// PUG_DEBUG:173
 ?><!----><?php } ?></div></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['detail-infrastructure'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(239);
// PUG_DEBUG:239
 ?><?php if ((isset($info) ? $info : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(238);
// PUG_DEBUG:238
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure'], ['id' => 'infrastructure'], ['data-screen' => 'infrastructure'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(227);
// PUG_DEBUG:227
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(219);
// PUG_DEBUG:219
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'title';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')], [false, 'detail-infrastructure__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(226);
// PUG_DEBUG:226
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure__buttons'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(225);
// PUG_DEBUG:225
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure__buttons-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(224);
// PUG_DEBUG:224
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'tabs') as $tab) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(223);
// PUG_DEBUG:223
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure__button'], ['for' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('for', (call_user_func($GLOBALS['__jpv_plus'], 'infrastructure_', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'button', 'value'))))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(220);
// PUG_DEBUG:220
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'radio'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'button', 'value'))], ['name' => 'infrastructure_tab'], ['v-model' => 'activeTab'], ['id' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('id', (call_user_func($GLOBALS['__jpv_plus'], 'infrastructure_', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'button', 'value'))))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(222);
// PUG_DEBUG:222
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure__button-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(221);
// PUG_DEBUG:221
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'button', 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></label><?php } ?></div></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(237);
// PUG_DEBUG:237
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure__tabs'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(236);
// PUG_DEBUG:236
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'tabs') as $tab) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(235);
// PUG_DEBUG:235
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'animation-fade';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](true, array(  ), [[false, '0.4']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(233);
// PUG_DEBUG:233
 ?><?php if (((isset($activeTab) ? $activeTab : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'button', 'value'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(232);
// PUG_DEBUG:232
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure__tab'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(228);
// PUG_DEBUG:228
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'picture';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'image')], [false, 'detail-infrastructure__tab-image'], [false, 'lazyload']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(231);
// PUG_DEBUG:231
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'], ['class' => 'detail-infrastructure__tab-main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(230);
// PUG_DEBUG:230
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-infrastructure__tab-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(229);
// PUG_DEBUG:229
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(234);
// PUG_DEBUG:234
 ?><!----><?php } ?><?php
}); ?><?php } ?></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(240);
// PUG_DEBUG:240
 ?><!----><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['map'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(250);
// PUG_DEBUG:250
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'map'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(249);
// PUG_DEBUG:249
 ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['label'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(252);
// PUG_DEBUG:252
 ?><?php $checked = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(253);
// PUG_DEBUG:253
 ?><!--  TODO: fix active state // не добавляется класс, если изначально в данных нет поля checked --><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(263);
// PUG_DEBUG:263
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'label'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), ((isset($checked) ? $checked : null) ? 'label--checked' : '') ))], ['@click' => 'toggleChecked'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(261);
// PUG_DEBUG:261
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(254);
// PUG_DEBUG:254
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(255);
// PUG_DEBUG:255
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(256);
// PUG_DEBUG:256
 ?>

<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(259);
// PUG_DEBUG:259
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'count')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(258);
// PUG_DEBUG:258
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'label__count'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(257);
// PUG_DEBUG:257
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'count')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(260);
// PUG_DEBUG:260
 ?><!----><?php } ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(262);
// PUG_DEBUG:262
 ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['detail-map'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(269);
// PUG_DEBUG:269
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-map'], ['id' => 'map'], ['data-screen' => 'map'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(266);
// PUG_DEBUG:266
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'], ['class' => 'detail-map__main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(265);
// PUG_DEBUG:265
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'title';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')], [false, 'detail-map__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(268);
// PUG_DEBUG:268
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-map__wrp'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(267);
// PUG_DEBUG:267
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'map';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['ref' => 'map']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'map')], [false, 'detail-map__map']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['filter-radio'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'buttons', null], [false, 'name', null], [false, 'className', null], [false, 'parentName', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(284);
// PUG_DEBUG:284
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-radio'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($buttons) ? $buttons : null), 'length') >= 3 ? 'filter-radio--big' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(283);
// PUG_DEBUG:283
 ?><?php foreach ($buttons as $radio) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(282);
// PUG_DEBUG:282
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-radio__item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(278);
// PUG_DEBUG:278
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'radio'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', (isset($name) ? $name : null))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($radio) ? $radio : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($radio) ? $radio : null), 'checked'))], ['v-model' => 'checked'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(281);
// PUG_DEBUG:281
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-radio__label'], ['@click' => 'checked = radio.value, $emit(\'change\', checked, name)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(279);
// PUG_DEBUG:279
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($radio) ? $radio : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(280);
// PUG_DEBUG:280
 ?></label></div><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['checkbox'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'obj', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(294);
// PUG_DEBUG:294
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(289);
// PUG_DEBUG:289
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__input'], ['type' => 'checkbox'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked'))], ['v-model' => 'obj.checked'], ['@change' => '$emit(\'change\', obj.checked)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(290);
// PUG_DEBUG:290
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(293);
// PUG_DEBUG:293
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(291);
// PUG_DEBUG:291
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(292);
// PUG_DEBUG:292
 ?></span></label><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['select'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null], [false, 'animationTime', null], [false, 'title', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(296);
// PUG_DEBUG:296
 ?><?php $selected = array( 'text' => '' ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(297);
// PUG_DEBUG:297
 ?><?php $isOpen = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(323);
// PUG_DEBUG:323
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), array( 'select--open' => (isset($isOpen) ? $isOpen : null) ), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple') ? 'select--multiple' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(306);
// PUG_DEBUG:306
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head'], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') : ''))], ['ref' => 'head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(300);
// PUG_DEBUG:300
 ?><?php if ((isset($title) ? $title : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(299);
// PUG_DEBUG:299
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__pre-title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(298);
// PUG_DEBUG:298
 ?><?= (is_bool($_pug_temp = (isset($title) ? $title : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(301);
// PUG_DEBUG:301
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(303);
// PUG_DEBUG:303
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(302);
// PUG_DEBUG:302
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($selected) ? $selected : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(305);
// PUG_DEBUG:305
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head-ico'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(304);
// PUG_DEBUG:304
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(322);
// PUG_DEBUG:322
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'animation-fade';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](true, array(  ), [[false, (isset($animationTime) ? $animationTime : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(320);
// PUG_DEBUG:320
 ?><?php if (((isset($isOpen) ? $isOpen : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(319);
// PUG_DEBUG:319
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__dropdown'], ['ref' => 'dropdown'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(313);
// PUG_DEBUG:313
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(312);
// PUG_DEBUG:312
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(311);
// PUG_DEBUG:311
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(310);
// PUG_DEBUG:310
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( array( 'select__li--active' => (function_exists('computedClass') ? computedClass((isset($item) ? $item : null)) : call_user_func((isset($computedClass) ? $computedClass : null), (isset($item) ? $item : null))) ), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled') ? 'select__li--disabled' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(308);
// PUG_DEBUG:308
 ?><?php if ((!call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(307);
// PUG_DEBUG:307
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'checkbox';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@change' => 'changeMultiple(item)']), [[false, (isset($item) ? $item : null)], [false, 'select__checkbox']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(309);
// PUG_DEBUG:309
 ?><!----><?php } ?></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(318);
// PUG_DEBUG:318
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(317);
// PUG_DEBUG:317
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(316);
// PUG_DEBUG:316
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['@click' => 'change(item)'], [':class' => '{&quot;select__li--active&quot; : computedClass(item)}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(315);
// PUG_DEBUG:315
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(314);
// PUG_DEBUG:314
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(321);
// PUG_DEBUG:321
 ?><!----><?php } ?><?php
}); ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['filter-range'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null], [false, 'name', null], [false, 'parentName', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(325);
// PUG_DEBUG:325
 ?><?php $showDropdown = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(326);
// PUG_DEBUG:326
 ?><?php $dropdown = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(327);
// PUG_DEBUG:327
 ?><?php $range = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'range') ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(328);
// PUG_DEBUG:328
 ?><?php $title = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'inputs', 'title') ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(362);
// PUG_DEBUG:362
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'range') ? 'filter-range--big' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(354);
// PUG_DEBUG:354
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(353);
// PUG_DEBUG:353
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__inputs'], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (isset($title) ? $title : null))], ['ref' => 'head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(332);
// PUG_DEBUG:332
 ?><?php if (((isset($name) ? $name : null) === 'price')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(331);
// PUG_DEBUG:331
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__inputs-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(329);
// PUG_DEBUG:329
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'value'))], ['@keyup' => 'formatPrice($event, info.inputs.min)'], ['v-model' => 'formData[info.inputs.min.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(330);
// PUG_DEBUG:330
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'value'))], ['@keyup' => 'formatPrice($event, info.inputs.max)'], ['v-model' => 'formData[info.inputs.max.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(335);
// PUG_DEBUG:335
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__inputs-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(333);
// PUG_DEBUG:333
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'value'))], ['v-model' => 'formData[info.inputs.min.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(334);
// PUG_DEBUG:334
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'value'))], ['v-model' => 'formData[info.inputs.max.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(351);
// PUG_DEBUG:351
 }  if (((isset($dropdown) ? $dropdown : null) && (isset($showDropdown) ? $showDropdown : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(350);
// PUG_DEBUG:350
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown'], ['ref' => 'drop'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(341);
// PUG_DEBUG:341
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($dropdown) ? $dropdown : null), 'min'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(340);
// PUG_DEBUG:340
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(339);
// PUG_DEBUG:339
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $dropdown, 'min') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(338);
// PUG_DEBUG:338
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-li'], ['@click' => 'change(item, \'min\')'], [':class' => '{&quot;filter-range__dropdown-li--active&quot; : computedClass(item, \'min\')}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(337);
// PUG_DEBUG:337
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(336);
// PUG_DEBUG:336
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(342);
// PUG_DEBUG:342
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(348);
// PUG_DEBUG:348
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($dropdown) ? $dropdown : null), 'max'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(347);
// PUG_DEBUG:347
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(346);
// PUG_DEBUG:346
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $dropdown, 'max') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(345);
// PUG_DEBUG:345
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-li'], ['@click' => 'change(item, \'max\')'], [':class' => '{&quot;filter-range__dropdown-li--active&quot; : computedClass(item, \'max\')}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(344);
// PUG_DEBUG:344
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(343);
// PUG_DEBUG:343
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(349);
// PUG_DEBUG:349
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(352);
// PUG_DEBUG:352
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(355);
// PUG_DEBUG:355
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(357);
// PUG_DEBUG:357
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'currency')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(356);
// PUG_DEBUG:356
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'select';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['v-model' => 'formData[info.currency.name]'], ['@input' => 'updateDropdown()']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'currency')], [false, 'filter-range__select filter-range__currency']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(358);
// PUG_DEBUG:358
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(360);
// PUG_DEBUG:360
 }  if ((isset($range) ? $range : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(359);
// PUG_DEBUG:359
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'select';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['v-model' => 'formData[range.name]'], ['@input' => 'updateDropdown()']), [[false, (isset($range) ? $range : null)], [false, 'filter-range__select filter-range__range']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(361);
// PUG_DEBUG:361
 ?><!----><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['animation-height'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'duration', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(408);
// PUG_DEBUG:408
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(407);
// PUG_DEBUG:407
 ?></transition><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['hint'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'obj', null], [false, 'className', null], [false, 'animationTime', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(442);
// PUG_DEBUG:442
 ?><?php $hints = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(479);
// PUG_DEBUG:479
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), array( 'hint--open' => (isset($isOpen) ? $isOpen : null) ) ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(452);
// PUG_DEBUG:452
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__head'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title') ? '' : 'hint__head--base'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(445);
// PUG_DEBUG:445
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(444);
// PUG_DEBUG:444
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(443);
// PUG_DEBUG:443
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(446);
// PUG_DEBUG:446
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(448);
// PUG_DEBUG:448
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__close'], ['@click' => 'closeDropDown()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(447);
// PUG_DEBUG:447
 ?><span></span></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(450);
// PUG_DEBUG:450
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'input')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(449);
// PUG_DEBUG:449
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__input'], ['type' => 'text'], ['v-model' => 'value'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'input', 'value'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'input', 'placeholder'))], ['autocomplete' => 'off'], ['@input' => 'getTips'], ['@change' => 'confirmValue()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(451);
// PUG_DEBUG:451
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(477);
// PUG_DEBUG:477
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($hints) ? $hints : null), 'length')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(476);
// PUG_DEBUG:476
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'animation-fade';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](true, array(  ), [[false, (isset($animationTime) ? $animationTime : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(475);
// PUG_DEBUG:475
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown'], ['v-if' => 'isOpen'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(474);
// PUG_DEBUG:474
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown-content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(472);
// PUG_DEBUG:472
 ?><?php if ((isset($hints) ? $hints : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(471);
// PUG_DEBUG:471
 ?><?php foreach ($hints as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(470);
// PUG_DEBUG:470
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown-item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(464);
// PUG_DEBUG:464
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(463);
// PUG_DEBUG:463
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown-head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(459);
// PUG_DEBUG:459
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'icon')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(458);
// PUG_DEBUG:458
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(454);
// PUG_DEBUG:454
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'icon') === 'pin2') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(453);
// PUG_DEBUG:453
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/pin2.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/pin2.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(456);
// PUG_DEBUG:456
 }  elseif(call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'icon') === 'sity') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(455);
// PUG_DEBUG:455
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/sity.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/sity.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(457);
// PUG_DEBUG:457
 ?><!----><?php } ?></svg><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(460);
// PUG_DEBUG:460
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(462);
// PUG_DEBUG:462
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(461);
// PUG_DEBUG:461
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(465);
// PUG_DEBUG:465
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(469);
// PUG_DEBUG:469
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__list'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(468);
// PUG_DEBUG:468
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'items') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(467);
// PUG_DEBUG:467
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__list-item'], ['class' => 'text'], ['@click' => 'change(el)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(466);
// PUG_DEBUG:466
 ?><?= (is_bool($_pug_temp = (isset($el) ? $el : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></li><?php } ?></ul></div><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(473);
// PUG_DEBUG:473
 ?><!----><?php } ?></div></div><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(478);
// PUG_DEBUG:478
 ?><!----><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['filter'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(481);
// PUG_DEBUG:481
 ?><?php $activeTab = '' ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(482);
// PUG_DEBUG:482
 ?><?php $showMore = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(483);
// PUG_DEBUG:483
 ?><?php $mainFields = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(484);
// PUG_DEBUG:484
 ?><?php $moreFields = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(485);
// PUG_DEBUG:485
 ?><?php $visibleButtons = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(486);
// PUG_DEBUG:486
 ?><?php $tags = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(487);
// PUG_DEBUG:487
 ?><?php $special = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(567);
// PUG_DEBUG:567
 ?><?php if (((isset($info) ? $info : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(566);
// PUG_DEBUG:566
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(564);
// PUG_DEBUG:564
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'tabs'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(563);
// PUG_DEBUG:563
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'tabs') as $tab) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(562);
// PUG_DEBUG:562
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__tab'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(560);
// PUG_DEBUG:560
 ?><?php if (((isset($activeTab) ? $activeTab : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'name'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(559);
// PUG_DEBUG:559
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__main'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'filter__main--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'type')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(510);
// PUG_DEBUG:510
 ?><?php if (((isset($mainFields) ? $mainFields : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(509);
// PUG_DEBUG:509
 ?><?php foreach ($mainFields as $field) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(508);
// PUG_DEBUG:508
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__field'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'filter__field--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type'), ' filter__field--', array( ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'radio') ? 'radio' : '') || ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'select') ? call_user_func($GLOBALS['__jpv_plus'], 'select filter__field--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')) : '') || ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'range' && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name') !== 'price') ? call_user_func($GLOBALS['__jpv_plus'], 'range filter__field--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')) : '') || ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') !== 'radio') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name') : '') )))], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') !== 'select' && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'title') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'title') : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(489);
// PUG_DEBUG:489
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'hidden')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(488);
// PUG_DEBUG:488
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'hidden'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'value'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(490);
// PUG_DEBUG:490
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(492);
// PUG_DEBUG:492
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'radio')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(491);
// PUG_DEBUG:491
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'filter-radio';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@change' => 'setFieldData']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'values')], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')], [false, call_user_func($GLOBALS['__jpv_plus'], 'filter__radio ', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'values', 'length') === 3 ? 'filter__radio--big' : ''))], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'name')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(494);
// PUG_DEBUG:494
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'select' && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name') === 'realty_type')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(493);
// PUG_DEBUG:493
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'select';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@input' => 'changeTab']), [[false, (isset($field) ? $field : null)], [false, 'filter__realty-select'], [false, '0.3']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(496);
// PUG_DEBUG:496
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'select')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(495);
// PUG_DEBUG:495
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'select';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@input' => 'setFieldData']), [[false, (isset($field) ? $field : null)], [false, 'filter__object-select'], [false, '0.3']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(498);
// PUG_DEBUG:498
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'range' && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name') === 'price')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(497);
// PUG_DEBUG:497
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'filter-range';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@change' => 'setRange']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'range')], [false, 'filter__price'], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'name')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(500);
// PUG_DEBUG:500
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'range')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(499);
// PUG_DEBUG:499
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'filter-range';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@change' => 'setRange']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'range')], [false, 'filter__range']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(502);
// PUG_DEBUG:502
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(501);
// PUG_DEBUG:501
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'btn';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@click' => 'openPopup(field.name)']), [[false, 'button'], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'text')], [false, 'btn--border filter__button']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(504);
// PUG_DEBUG:504
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'input' && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name') === 'search')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(503);
// PUG_DEBUG:503
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'hint';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@passHint' => 'setFieldData']), [[false, (isset($field) ? $field : null)], [false, 'filter-address filter__addres']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(506);
// PUG_DEBUG:506
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'hidden')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(505);
// PUG_DEBUG:505
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['type' => 'hidden'], ['name' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name'))], ['value' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'value'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(507);
// PUG_DEBUG:507
 ?><!----><?php } ?></div><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(511);
// PUG_DEBUG:511
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(525);
// PUG_DEBUG:525
 }  if (((isset($moreFields) ? $moreFields : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($moreFields) ? $moreFields : null), 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(524);
// PUG_DEBUG:524
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'animation-height';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](true, array(  ), [[false, '0.4']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(522);
// PUG_DEBUG:522
 ?><?php if (((isset($showMore) ? $showMore : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(521);
// PUG_DEBUG:521
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__hidden'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(520);
// PUG_DEBUG:520
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__main'], ['class' => 'filter__main--hidden'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(519);
// PUG_DEBUG:519
 ?><?php foreach ($moreFields as $element) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(518);
// PUG_DEBUG:518
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__field'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'filter__field--', array( ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'type') === 'radio') ? 'radio' : '') || ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'type') === 'select') ? call_user_func($GLOBALS['__jpv_plus'], 'select filter__field--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'name')) : '') || ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'type') === 'range' && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'name') !== 'price') ? call_user_func($GLOBALS['__jpv_plus'], 'range filter__field--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'name')) : '') || ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'type') !== 'radio') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'name') : '') )))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(513);
// PUG_DEBUG:513
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'type') === 'range')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(512);
// PUG_DEBUG:512
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'filter-range';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@change' => 'setRange']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'range')], [false, 'filter__range'], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'name')], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'name')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(514);
// PUG_DEBUG:514
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(516);
// PUG_DEBUG:516
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($element) ? $element : null), 'type') === 'select')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(515);
// PUG_DEBUG:515
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'select';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@input' => 'setFieldData']), [[false, (isset($element) ? $element : null)], [false, 'filter__hidden-select'], [false, '0.3']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(517);
// PUG_DEBUG:517
 ?><!----><?php } ?></div><?php } ?></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(523);
// PUG_DEBUG:523
 ?><!----><?php } ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(526);
// PUG_DEBUG:526
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(552);
// PUG_DEBUG:552
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__buttons'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(545);
// PUG_DEBUG:545
 ?><?php if ((((isset($visibleButtons) ? $visibleButtons : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($visibleButtons) ? $visibleButtons : null), 'length') !== 0) || ((isset($special) ? $special : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($special) ? $special : null), 'length') > 0))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(544);
// PUG_DEBUG:544
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__popup-btns'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(536);
// PUG_DEBUG:536
 ?><?php if (((isset($visibleButtons) ? $visibleButtons : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($visibleButtons) ? $visibleButtons : null), 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(535);
// PUG_DEBUG:535
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__popup-btns-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(534);
// PUG_DEBUG:534
 ?><?php foreach ($visibleButtons as $btn) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(533);
// PUG_DEBUG:533
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__popup-btn'], ['@click' => 'openPopup(btn)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(528);
// PUG_DEBUG:528
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(527);
// PUG_DEBUG:527
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(531);
// PUG_DEBUG:531
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(530);
// PUG_DEBUG:530
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__popup-btn-count'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(529);
// PUG_DEBUG:529
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(532);
// PUG_DEBUG:532
 ?><!----><?php } ?></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(537);
// PUG_DEBUG:537
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(542);
// PUG_DEBUG:542
 }  if (((isset($special) ? $special : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($special) ? $special : null), 'length'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(541);
// PUG_DEBUG:541
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__tags'], ['class' => 'filter__tags--filter'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(540);
// PUG_DEBUG:540
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__tags-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(539);
// PUG_DEBUG:539
 ?><?php foreach ($special as $index => $tag) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(538);
// PUG_DEBUG:538
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'label';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes']([':key' => 'tag.value'], ['@change' => 'setTag(tag)']), [[false, (isset($tag) ? $tag : null)], [false, 'filter__tag filter__tag--rect']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } ?></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(543);
// PUG_DEBUG:543
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(546);
// PUG_DEBUG:546
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(550);
// PUG_DEBUG:550
 }  if (((isset($moreFields) ? $moreFields : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($moreFields) ? $moreFields : null), 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(549);
// PUG_DEBUG:549
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__more'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', ((isset($showMore) ? $showMore : null) ? 'filter__more--open' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(548);
// PUG_DEBUG:548
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['@click' => 'toggleMore'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(547);
// PUG_DEBUG:547
 ?><?= (is_bool($_pug_temp = ((isset($showMore) ? $showMore : null) ? 'Скрыть фильтры' : 'Еще фильтры')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(551);
// PUG_DEBUG:551
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(557);
// PUG_DEBUG:557
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'tags') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'tags', 'list'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(556);
// PUG_DEBUG:556
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__tags'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(555);
// PUG_DEBUG:555
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter__tags-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(554);
// PUG_DEBUG:554
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $tab, 'tags', 'list') as $tag) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(553);
// PUG_DEBUG:553
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'label';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@change' => 'setTag(tag)']), [[false, (isset($tag) ? $tag : null)], [false, 'filter__tag']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } ?></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(558);
// PUG_DEBUG:558
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(561);
// PUG_DEBUG:561
 ?><!----><?php } ?></div><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(565);
// PUG_DEBUG:565
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(568);
// PUG_DEBUG:568
 ?><!----><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['card-gallery'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'slides', null], [false, 'className', null], [false, 'paginationClass', null], [false, 'isPrev', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(585);
// PUG_DEBUG:585
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery'], ['class' => 'swiper-container'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(570);
// PUG_DEBUG:570
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__pagination'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($paginationClass) ? $paginationClass : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(578);
// PUG_DEBUG:578
 ?><?php if (((isset($isPrev) ? $isPrev : null) === true && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($slides) ? $slides : null), 'length') > 1)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(577);
// PUG_DEBUG:577
 ?><div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(573);
// PUG_DEBUG:573
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__btn'], ['class' => 'swiper-button-prev'], ['@click.stop' => 'prev'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(572);
// PUG_DEBUG:572
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(571);
// PUG_DEBUG:571
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => '/assets/sprite.svg#arrow-left'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(576);
// PUG_DEBUG:576
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__btn'], ['class' => 'swiper-button-next'], ['@click.stop' => 'next'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(575);
// PUG_DEBUG:575
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(574);
// PUG_DEBUG:574
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => '/assets/sprite.svg#arrow-right2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(579);
// PUG_DEBUG:579
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(584);
// PUG_DEBUG:584
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-wrapper'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(583);
// PUG_DEBUG:583
 ?><?php foreach ($slides as $slide) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(582);
// PUG_DEBUG:582
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-slide'], ['class' => 'card-gallery__slide'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(580);
// PUG_DEBUG:580
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__image'], ['class' => 'lazyload'], ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', (isset($slide) ? $slide : null))], ['alt' => ''])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(581);
// PUG_DEBUG:581
 ?></div><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['card-small'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'card', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(693);
// PUG_DEBUG:693
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(588);
// PUG_DEBUG:588
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'link'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(587);
// PUG_DEBUG:587
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(600);
// PUG_DEBUG:600
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__gallery-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(589);
// PUG_DEBUG:589
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'card-gallery';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'images')], [false, 'card-small__gallery'], [false, 'card-small__pagination']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(592);
// PUG_DEBUG:592
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'deal_type'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(591);
// PUG_DEBUG:591
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__label'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(590);
// PUG_DEBUG:590
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'deal_type')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(593);
// PUG_DEBUG:593
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(598);
// PUG_DEBUG:598
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'id'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(597);
// PUG_DEBUG:597
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__id'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(594);
// PUG_DEBUG:594
 ?>ID: <?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(595);
// PUG_DEBUG:595
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'id')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(596);
// PUG_DEBUG:596
 ?>

</div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(599);
// PUG_DEBUG:599
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(692);
// PUG_DEBUG:692
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(683);
// PUG_DEBUG:683
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(602);
// PUG_DEBUG:602
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(601);
// PUG_DEBUG:601
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(605);
// PUG_DEBUG:605
 ?><button<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__favorite'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'isFav') ? 'card-small__favorite--added' : ''))], ['@click' => 'toggleFav()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(604);
// PUG_DEBUG:604
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(603);
// PUG_DEBUG:603
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/like.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/like.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></button><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(608);
// PUG_DEBUG:608
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'name'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(607);
// PUG_DEBUG:607
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__text'], ['class' => 'card-small__text--gray'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(606);
// PUG_DEBUG:606
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'name')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(609);
// PUG_DEBUG:609
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(612);
// PUG_DEBUG:612
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'address'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(611);
// PUG_DEBUG:611
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__text'], ['class' => 'card-small__text--gray'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(610);
// PUG_DEBUG:610
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'address')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(613);
// PUG_DEBUG:613
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(681);
// PUG_DEBUG:681
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'specs'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(680);
// PUG_DEBUG:680
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'card-small__specs--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'card_type')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(679);
// PUG_DEBUG:679
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $card, 'info') as $spec => $text) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(678);
// PUG_DEBUG:678
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs-item'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'card-small__specs-item--', (isset($spec) ? $spec : null)))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(616);
// PUG_DEBUG:616
 ?><?php if ((isset($spec) ? $spec : null) === 'ring') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(615);
// PUG_DEBUG:615
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(614);
// PUG_DEBUG:614
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/ring.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/ring.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(619);
// PUG_DEBUG:619
 }  if ((isset($spec) ? $spec : null) === 'square') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(618);
// PUG_DEBUG:618
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(617);
// PUG_DEBUG:617
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/ruller.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/ruller.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(622);
// PUG_DEBUG:622
 }  if ((isset($spec) ? $spec : null) === 'date') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(621);
// PUG_DEBUG:621
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '14'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(620);
// PUG_DEBUG:620
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/calendar.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/calendar.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(625);
// PUG_DEBUG:625
 }  if ((isset($spec) ? $spec : null) === 'facing') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(624);
// PUG_DEBUG:624
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '14'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(623);
// PUG_DEBUG:623
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/facing.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/facing.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(628);
// PUG_DEBUG:628
 }  if ((isset($spec) ? $spec : null) === 'area') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(627);
// PUG_DEBUG:627
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '15'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(626);
// PUG_DEBUG:626
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/fences.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/fences.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(631);
// PUG_DEBUG:631
 }  if ((isset($spec) ? $spec : null) === 'rooms') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(630);
// PUG_DEBUG:630
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(629);
// PUG_DEBUG:629
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/room.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/room.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(634);
// PUG_DEBUG:634
 }  if ((isset($spec) ? $spec : null) === 'bedrooms') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(633);
// PUG_DEBUG:633
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(632);
// PUG_DEBUG:632
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/bed.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/bed.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(637);
// PUG_DEBUG:637
 }  if ((isset($spec) ? $spec : null) === 'floor') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(636);
// PUG_DEBUG:636
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '14'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(635);
// PUG_DEBUG:635
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/apartment.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/apartment.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(640);
// PUG_DEBUG:640
 }  if ((isset($spec) ? $spec : null) === 'metro') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(639);
// PUG_DEBUG:639
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '18'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(638);
// PUG_DEBUG:638
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/bus.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/bus.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(643);
// PUG_DEBUG:643
 }  if ((isset($spec) ? $spec : null) === 'forest') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(642);
// PUG_DEBUG:642
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(641);
// PUG_DEBUG:641
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/trees.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/trees.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(646);
// PUG_DEBUG:646
 }  if ((isset($spec) ? $spec : null) === 'water') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(645);
// PUG_DEBUG:645
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(644);
// PUG_DEBUG:644
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/waves.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/waves.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(649);
// PUG_DEBUG:649
 }  if ((isset($spec) ? $spec : null) === 'parking') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(648);
// PUG_DEBUG:648
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(647);
// PUG_DEBUG:647
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/parking.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/parking.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(652);
// PUG_DEBUG:652
 }  if ((isset($spec) ? $spec : null) === 'distance') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(651);
// PUG_DEBUG:651
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '15'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(650);
// PUG_DEBUG:650
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/route.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/route.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(655);
// PUG_DEBUG:655
 }  if ((isset($spec) ? $spec : null) === 'gas') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(654);
// PUG_DEBUG:654
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '15'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(653);
// PUG_DEBUG:653
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/gas.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/gas.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(658);
// PUG_DEBUG:658
 }  if ((isset($spec) ? $spec : null) === 'cleaner') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(657);
// PUG_DEBUG:657
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '15'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(656);
// PUG_DEBUG:656
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/septik.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/septik.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(661);
// PUG_DEBUG:661
 }  if ((isset($spec) ? $spec : null) === 'pump') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(660);
// PUG_DEBUG:660
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '16'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(659);
// PUG_DEBUG:659
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/pumpjack.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/pumpjack.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(664);
// PUG_DEBUG:664
 }  if ((isset($spec) ? $spec : null) === 'sewage') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(663);
// PUG_DEBUG:663
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(662);
// PUG_DEBUG:662
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/kanaliz.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/kanaliz.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(667);
// PUG_DEBUG:667
 }  if ((isset($spec) ? $spec : null) === 'class') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(666);
// PUG_DEBUG:666
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '13'], ['width' => '13'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(665);
// PUG_DEBUG:665
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/class.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/class.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(675);
// PUG_DEBUG:675
 }  if ((isset($spec) ? $spec : null) === 'metro') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(674);
// PUG_DEBUG:674
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs-item-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(669);
// PUG_DEBUG:669
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(668);
// PUG_DEBUG:668
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($text) ? $text : null), 'station')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(672);
// PUG_DEBUG:672
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($text) ? $text : null), 'walk'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(671);
// PUG_DEBUG:671
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(670);
// PUG_DEBUG:670
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_plus'], ', ', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($text) ? $text : null), 'walk'))) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(673);
// PUG_DEBUG:673
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(677);
// PUG_DEBUG:677
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs-item-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(676);
// PUG_DEBUG:676
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } ?></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(682);
// PUG_DEBUG:682
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(686);
// PUG_DEBUG:686
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'price'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(685);
// PUG_DEBUG:685
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__price'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(684);
// PUG_DEBUG:684
 ?><?= (is_bool($_pug_temp = (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'price', 'request') ? 'По запросу' : call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'price', 'total'))) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(687);
// PUG_DEBUG:687
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(690);
// PUG_DEBUG:690
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'allObjects'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(689);
// PUG_DEBUG:689
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__all-objects'], ['href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'allObjects', 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(688);
// PUG_DEBUG:688
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'allObjects', 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(691);
// PUG_DEBUG:691
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['catalog-list'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(697);
// PUG_DEBUG:697
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(695);
// PUG_DEBUG:695
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'catalog-list'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(696);
// PUG_DEBUG:696
 ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['filter-noResult'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null], [false, 'resetBtn', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(706);
// PUG_DEBUG:706
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-noResult'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(700);
// PUG_DEBUG:700
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-noResult__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(699);
// PUG_DEBUG:699
 ?><?= (is_bool($_pug_temp = (isset($info) ? $info : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(703);
// PUG_DEBUG:703
 ?><?php if (((isset($resetBtn) ? $resetBtn : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(702);
// PUG_DEBUG:702
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-noResult__button'], ['@click' => 'resetFilter'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(701);
// PUG_DEBUG:701
 ?>Сбросить фильтр</div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(704);
// PUG_DEBUG:704
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(705);
// PUG_DEBUG:705
 ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['pagination'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(718);
// PUG_DEBUG:718
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'pagination'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(710);
// PUG_DEBUG:710
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'pagination__btn'], ['class' => 'pagination__btn--prev'], ['@click' => 'changePage(&quot;prev&quot;)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(709);
// PUG_DEBUG:709
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(708);
// PUG_DEBUG:708
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(713);
// PUG_DEBUG:713
 ?><?php foreach (call_user_func(call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $util, 'pagination'), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'current'), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'count')) as $i) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(712);
// PUG_DEBUG:712
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'pagination__link'], ['@click.prevent.stop' => 'changePage(i)'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( ((isset($i) ? $i : null) === '...' ? 'pagination__link--empty' : ''), ((isset($i) ? $i : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'current') ? 'pagination__link--active' : '') ))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', ((isset($i) ? $i : null) !== '...') ? call_user_func($GLOBALS['__jpv_plus'], call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'url'), '?', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'param'), '=', (isset($i) ? $i : null)) : '')])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(711);
// PUG_DEBUG:711
 ?><?= (is_bool($_pug_temp = (isset($i) ? $i : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(717);
// PUG_DEBUG:717
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'pagination__btn'], ['class' => 'pagination__btn--next'], ['@click' => 'changePage(&quot;next&quot;)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(716);
// PUG_DEBUG:716
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(715);
// PUG_DEBUG:715
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(714);
// PUG_DEBUG:714
 ?></use></svg></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['detail-offers'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(740);
// PUG_DEBUG:740
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-offers'], ['id' => 'offers'], ['data-screen' => 'offers'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(739);
// PUG_DEBUG:739
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(720);
// PUG_DEBUG:720
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'title';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')], [false, 'detail-offers__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(729);
// PUG_DEBUG:729
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'filter'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(728);
// PUG_DEBUG:728
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-offers__filter-wrap'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(721);
// PUG_DEBUG:721
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'filter';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@filterSubmit' => 'submitFilter']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'filter')], [false, 'detail-offers__filter']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(726);
// PUG_DEBUG:726
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'filter', 'popupButtons'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(725);
// PUG_DEBUG:725
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-offers__popup-btns'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(724);
// PUG_DEBUG:724
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'filter', 'popupButtons') as $btn) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(723);
// PUG_DEBUG:723
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-offers__popup-btn'], ['@click' => 'openPopup(btn.popup)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(722);
// PUG_DEBUG:722
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(727);
// PUG_DEBUG:727
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(730);
// PUG_DEBUG:730
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(734);
// PUG_DEBUG:734
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'cards') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'cards', 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(733);
// PUG_DEBUG:733
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'catalog-list';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](true, array(  ), [[false, 'catalog-list--tiles']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(732);
// PUG_DEBUG:732
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'cards') as $card) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(731);
// PUG_DEBUG:731
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'card-small';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes']([':key' => 'card.id']), [[false, (isset($card) ? $card : null)], [false, 'catalog-list__card-small']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php };
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(735);
// PUG_DEBUG:735
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'filter-noResult';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'error')], [false, 'detail-offers__error']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(737);
// PUG_DEBUG:737
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'cards') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'pagination') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'pagination', 'count') >= 2)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(736);
// PUG_DEBUG:736
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'pagination';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@setPage' => 'setPage']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'pagination')], [false, 'detail-offers__pagination']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(738);
// PUG_DEBUG:738
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-second'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(744);
// PUG_DEBUG:744
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-second'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(742);
// PUG_DEBUG:742
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(743);
// PUG_DEBUG:743
 ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['input'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'obj', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(751);
// PUG_DEBUG:751
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'type') === 'hidden')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(750);
// PUG_DEBUG:750
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('type', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'type'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(760);
// PUG_DEBUG:760
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'className'), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked') && (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'value') === 'fail') ? 'input--fail' : ''), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked') && (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'value') === 'success') ? 'input--success' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(754);
// PUG_DEBUG:754
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input__icon'], ['class' => 'input__icon--fail'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(753);
// PUG_DEBUG:753
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(752);
// PUG_DEBUG:752
 ?>!</span></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(757);
// PUG_DEBUG:757
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input__icon'], ['class' => 'input__icon--success'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(756);
// PUG_DEBUG:756
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(755);
// PUG_DEBUG:755
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/check.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/check.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(758);
// PUG_DEBUG:758
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input__item'], ['ref' => 'input'], ['type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('type', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'type'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], [':value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'placeholder'))], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['maxlength' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('maxlength', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'lengthString') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'lengthString', 'max') : ''))], ['@input' => 'inputDefault($event.target.value)'], ['@change' => 'change($event.target.value)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(759);
// PUG_DEBUG:759
 ?></div><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['banner-request'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null], [false, 'imgModif', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(834);
// PUG_DEBUG:834
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-request'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(817);
// PUG_DEBUG:817
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'picture')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(816);
// PUG_DEBUG:816
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'picture';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'picture')], [false, call_user_func($GLOBALS['__jpv_plus'], 'banner-request__background', ' ', (isset($imgModif) ? $imgModif : null))], [false, 'lazyload']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(818);
// PUG_DEBUG:818
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(833);
// PUG_DEBUG:833
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-request__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(820);
// PUG_DEBUG:820
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(819);
// PUG_DEBUG:819
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'title-second';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')], [false, 'banner-request__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(821);
// PUG_DEBUG:821
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(831);
// PUG_DEBUG:831
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(830);
// PUG_DEBUG:830
 ?><form<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-request__form'], ['action' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('action', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'url'))], ['@submit.prevent' => 'onSubmit'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(823);
// PUG_DEBUG:823
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'form', 'inputs') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(822);
// PUG_DEBUG:822
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'input';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['v-model' => 'formModel[item.name]']), [[false, (isset($item) ? $item : null)], [false, 'banner-request__input']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(825);
// PUG_DEBUG:825
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'btn')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(824);
// PUG_DEBUG:824
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'btn';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, 'button'], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'btn')], [false, 'banner-request__btn'], [false, (!call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'checkbox', 'checked'))]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(826);
// PUG_DEBUG:826
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(828);
// PUG_DEBUG:828
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'checkbox')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(827);
// PUG_DEBUG:827
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'checkbox';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'checkbox')], [false, 'banner-request__checkbox']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(829);
// PUG_DEBUG:829
 ?><!----><?php } ?></form><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(832);
// PUG_DEBUG:832
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['detail-district'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(863);
// PUG_DEBUG:863
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(837);
// PUG_DEBUG:837
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'main'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(836);
// PUG_DEBUG:836
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'detail-district-main';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'main')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(838);
// PUG_DEBUG:838
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(862);
// PUG_DEBUG:862
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(840);
// PUG_DEBUG:840
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'nav'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(839);
// PUG_DEBUG:839
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'detail-nav';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['ref' => 'nav']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'nav')], [false, ''], [false, (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'offers') ? '#offers' : false)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(841);
// PUG_DEBUG:841
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(843);
// PUG_DEBUG:843
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'about'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(842);
// PUG_DEBUG:842
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'detail-district-about';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'about')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(844);
// PUG_DEBUG:844
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(846);
// PUG_DEBUG:846
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'infrastructure'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(845);
// PUG_DEBUG:845
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'detail-infrastructure';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'infrastructure')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(847);
// PUG_DEBUG:847
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(849);
// PUG_DEBUG:849
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'map'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(848);
// PUG_DEBUG:848
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'detail-map';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'map')], [false, 'detail-district__map']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(850);
// PUG_DEBUG:850
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(852);
// PUG_DEBUG:852
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'offers'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(851);
// PUG_DEBUG:851
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'detail-offers';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'offers')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(853);
// PUG_DEBUG:853
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(861);
// PUG_DEBUG:861
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(855);
// PUG_DEBUG:855
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'request'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(854);
// PUG_DEBUG:854
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'banner-request';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'request')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(856);
// PUG_DEBUG:856
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(860);
// PUG_DEBUG:860
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district__desc'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(858);
// PUG_DEBUG:858
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'detail-district__desc-title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(857);
// PUG_DEBUG:857
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'desc', 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(859);
// PUG_DEBUG:859
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'text';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'desc', 'describe')], [false, 'detail-district__desc-text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?></div></div></div></div><?php
}; ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(866);
// PUG_DEBUG:866
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(864);
// PUG_DEBUG:864
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(5);
// PUG_DEBUG:5
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(21);
// PUG_DEBUG:21
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(25);
// PUG_DEBUG:25
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(28);
// PUG_DEBUG:28
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(68);
// PUG_DEBUG:68
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(44);
// PUG_DEBUG:44
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_5471439 = $__pug_mixins['btn'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['btn'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'tag', null], [false, 'text', null], [false, 'className', null], [false, 'disabled', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(33);
// PUG_DEBUG:33
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(32);
// PUG_DEBUG:32
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(29);
// PUG_DEBUG:29
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(31);
// PUG_DEBUG:31
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(30);
// PUG_DEBUG:30
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(38);
// PUG_DEBUG:38
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(37);
// PUG_DEBUG:37
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(34);
// PUG_DEBUG:34
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(36);
// PUG_DEBUG:36
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(35);
// PUG_DEBUG:35
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(43);
// PUG_DEBUG:43
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(39);
// PUG_DEBUG:39
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(41);
// PUG_DEBUG:41
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(40);
// PUG_DEBUG:40
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(42);
// PUG_DEBUG:42
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_5471439)) {
    $__pug_mixins['btn'] = $__pug_save_5471439;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(146);
// PUG_DEBUG:146
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(74);
// PUG_DEBUG:74
 ?><?php if (isset($__pug_mixins, $__pug_mixins['breadcrumbs'])) {
    $__pug_save_6939135 = $__pug_mixins['breadcrumbs'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['breadcrumbs'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'links', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(73);
// PUG_DEBUG:73
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'breadcrumbs'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(72);
// PUG_DEBUG:72
 ?><?php foreach ($links as $link) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(71);
// PUG_DEBUG:71
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'breadcrumbs__link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($link) ? $link : null), 'href'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(69);
// PUG_DEBUG:69
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($link) ? $link : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(70);
// PUG_DEBUG:70
 ?></a><?php } ?></div><?php
}; ?><?php if (isset($__pug_save_6939135)) {
    $__pug_mixins['breadcrumbs'] = $__pug_save_6939135;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(105);
// PUG_DEBUG:105
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(121);
// PUG_DEBUG:121
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_7799895 = $__pug_mixins['btn'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['btn'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'tag', null], [false, 'text', null], [false, 'className', null], [false, 'disabled', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(110);
// PUG_DEBUG:110
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(109);
// PUG_DEBUG:109
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(106);
// PUG_DEBUG:106
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(108);
// PUG_DEBUG:108
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(107);
// PUG_DEBUG:107
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(115);
// PUG_DEBUG:115
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(114);
// PUG_DEBUG:114
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(111);
// PUG_DEBUG:111
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(113);
// PUG_DEBUG:113
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(112);
// PUG_DEBUG:112
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(120);
// PUG_DEBUG:120
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(116);
// PUG_DEBUG:116
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(118);
// PUG_DEBUG:118
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(117);
// PUG_DEBUG:117
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(119);
// PUG_DEBUG:119
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_7799895)) {
    $__pug_mixins['btn'] = $__pug_save_7799895;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(125);
// PUG_DEBUG:125
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(177);
// PUG_DEBUG:177
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(153);
// PUG_DEBUG:153
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(157);
// PUG_DEBUG:157
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_8368054 = $__pug_mixins['text'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['text'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(156);
// PUG_DEBUG:156
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(154);
// PUG_DEBUG:154
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(155);
// PUG_DEBUG:155
 ?></p><?php
}; ?><?php if (isset($__pug_save_8368054)) {
    $__pug_mixins['text'] = $__pug_save_8368054;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(241);
// PUG_DEBUG:241
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(180);
// PUG_DEBUG:180
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-fade'])) {
    $__pug_save_7888616 = $__pug_mixins['animation-fade'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['animation-fade'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'duration', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(179);
// PUG_DEBUG:179
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(178);
// PUG_DEBUG:178
 ?></transition><?php
}; ?><?php if (isset($__pug_save_7888616)) {
    $__pug_mixins['animation-fade'] = $__pug_save_7888616;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(187);
// PUG_DEBUG:187
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_8934534 = $__pug_mixins['title'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null], [false, 'link', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(183);
// PUG_DEBUG:183
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(182);
// PUG_DEBUG:182
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(181);
// PUG_DEBUG:181
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(186);
// PUG_DEBUG:186
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(184);
// PUG_DEBUG:184
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(185);
// PUG_DEBUG:185
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_8934534)) {
    $__pug_mixins['title'] = $__pug_save_8934534;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(218);
// PUG_DEBUG:218
 ?><?php if (isset($__pug_mixins, $__pug_mixins['picture'])) {
    $__pug_save_2398459 = $__pug_mixins['picture'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['picture'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'data', null], [false, 'className', null], [false, 'optimize', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(202);
// PUG_DEBUG:202
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(201);
// PUG_DEBUG:201
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(190);
// PUG_DEBUG:190
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(189);
// PUG_DEBUG:189
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(188);
// PUG_DEBUG:188
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(191);
// PUG_DEBUG:191
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(194);
// PUG_DEBUG:194
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(193);
// PUG_DEBUG:193
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(192);
// PUG_DEBUG:192
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(195);
// PUG_DEBUG:195
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(198);
// PUG_DEBUG:198
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(197);
// PUG_DEBUG:197
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(196);
// PUG_DEBUG:196
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(199);
// PUG_DEBUG:199
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(200);
// PUG_DEBUG:200
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(217);
// PUG_DEBUG:217
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(205);
// PUG_DEBUG:205
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(204);
// PUG_DEBUG:204
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(203);
// PUG_DEBUG:203
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(206);
// PUG_DEBUG:206
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(209);
// PUG_DEBUG:209
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(208);
// PUG_DEBUG:208
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(207);
// PUG_DEBUG:207
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(210);
// PUG_DEBUG:210
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(213);
// PUG_DEBUG:213
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(212);
// PUG_DEBUG:212
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(211);
// PUG_DEBUG:211
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(214);
// PUG_DEBUG:214
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(215);
// PUG_DEBUG:215
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(216);
// PUG_DEBUG:216
 ?></picture><?php } ?><?php
}; ?><?php if (isset($__pug_save_2398459)) {
    $__pug_mixins['picture'] = $__pug_save_2398459;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(270);
// PUG_DEBUG:270
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(248);
// PUG_DEBUG:248
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_2900776 = $__pug_mixins['title'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null], [false, 'link', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(244);
// PUG_DEBUG:244
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(243);
// PUG_DEBUG:243
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(242);
// PUG_DEBUG:242
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(247);
// PUG_DEBUG:247
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(245);
// PUG_DEBUG:245
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(246);
// PUG_DEBUG:246
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_2900776)) {
    $__pug_mixins['title'] = $__pug_save_2900776;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(251);
// PUG_DEBUG:251
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(264);
// PUG_DEBUG:264
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(741);
// PUG_DEBUG:741
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(277);
// PUG_DEBUG:277
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_1950334 = $__pug_mixins['title'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null], [false, 'link', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(273);
// PUG_DEBUG:273
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(272);
// PUG_DEBUG:272
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(271);
// PUG_DEBUG:271
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(276);
// PUG_DEBUG:276
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(274);
// PUG_DEBUG:274
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(275);
// PUG_DEBUG:275
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_1950334)) {
    $__pug_mixins['title'] = $__pug_save_1950334;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(569);
// PUG_DEBUG:569
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(285);
// PUG_DEBUG:285
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(363);
// PUG_DEBUG:363
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(324);
// PUG_DEBUG:324
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(288);
// PUG_DEBUG:288
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-fade'])) {
    $__pug_save_5837650 = $__pug_mixins['animation-fade'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['animation-fade'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'duration', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(287);
// PUG_DEBUG:287
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(286);
// PUG_DEBUG:286
 ?></transition><?php
}; ?><?php if (isset($__pug_save_5837650)) {
    $__pug_mixins['animation-fade'] = $__pug_save_5837650;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(295);
// PUG_DEBUG:295
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(367);
// PUG_DEBUG:367
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(406);
// PUG_DEBUG:406
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(370);
// PUG_DEBUG:370
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-fade'])) {
    $__pug_save_491309 = $__pug_mixins['animation-fade'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['animation-fade'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'duration', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(369);
// PUG_DEBUG:369
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(368);
// PUG_DEBUG:368
 ?></transition><?php
}; ?><?php if (isset($__pug_save_491309)) {
    $__pug_mixins['animation-fade'] = $__pug_save_491309;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(377);
// PUG_DEBUG:377
 ?><?php if (isset($__pug_mixins, $__pug_mixins['checkbox'])) {
    $__pug_save_4137459 = $__pug_mixins['checkbox'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['checkbox'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'obj', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(376);
// PUG_DEBUG:376
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(371);
// PUG_DEBUG:371
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__input'], ['type' => 'checkbox'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked'))], ['v-model' => 'obj.checked'], ['@change' => '$emit(\'change\', obj.checked)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(372);
// PUG_DEBUG:372
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(375);
// PUG_DEBUG:375
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(373);
// PUG_DEBUG:373
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(374);
// PUG_DEBUG:374
 ?></span></label><?php
}; ?><?php if (isset($__pug_save_4137459)) {
    $__pug_mixins['checkbox'] = $__pug_save_4137459;
}
 ?><?php if (isset($__pug_mixins, $__pug_mixins['select'])) {
    $__pug_save_3496639 = $__pug_mixins['select'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['select'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null], [false, 'animationTime', null], [false, 'title', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(378);
// PUG_DEBUG:378
 ?><?php $selected = array( 'text' => '' ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(379);
// PUG_DEBUG:379
 ?><?php $isOpen = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(405);
// PUG_DEBUG:405
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), array( 'select--open' => (isset($isOpen) ? $isOpen : null) ), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple') ? 'select--multiple' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(388);
// PUG_DEBUG:388
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head'], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') : ''))], ['ref' => 'head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(382);
// PUG_DEBUG:382
 ?><?php if ((isset($title) ? $title : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(381);
// PUG_DEBUG:381
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__pre-title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(380);
// PUG_DEBUG:380
 ?><?= (is_bool($_pug_temp = (isset($title) ? $title : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(383);
// PUG_DEBUG:383
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(385);
// PUG_DEBUG:385
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(384);
// PUG_DEBUG:384
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($selected) ? $selected : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(387);
// PUG_DEBUG:387
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head-ico'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(386);
// PUG_DEBUG:386
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(404);
// PUG_DEBUG:404
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'animation-fade';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](true, array(  ), [[false, (isset($animationTime) ? $animationTime : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(402);
// PUG_DEBUG:402
 ?><?php if (((isset($isOpen) ? $isOpen : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(401);
// PUG_DEBUG:401
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__dropdown'], ['ref' => 'dropdown'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(395);
// PUG_DEBUG:395
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(394);
// PUG_DEBUG:394
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(393);
// PUG_DEBUG:393
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(392);
// PUG_DEBUG:392
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( array( 'select__li--active' => (function_exists('computedClass') ? computedClass((isset($item) ? $item : null)) : call_user_func((isset($computedClass) ? $computedClass : null), (isset($item) ? $item : null))) ), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled') ? 'select__li--disabled' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(390);
// PUG_DEBUG:390
 ?><?php if ((!call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(389);
// PUG_DEBUG:389
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'checkbox';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@change' => 'changeMultiple(item)']), [[false, (isset($item) ? $item : null)], [false, 'select__checkbox']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(391);
// PUG_DEBUG:391
 ?><!----><?php } ?></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(400);
// PUG_DEBUG:400
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(399);
// PUG_DEBUG:399
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(398);
// PUG_DEBUG:398
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['@click' => 'change(item)'], [':class' => '{&quot;select__li--active&quot; : computedClass(item)}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(397);
// PUG_DEBUG:397
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(396);
// PUG_DEBUG:396
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(403);
// PUG_DEBUG:403
 ?><!----><?php } ?><?php
}); ?></div><?php
}; ?><?php if (isset($__pug_save_3496639)) {
    $__pug_mixins['select'] = $__pug_save_3496639;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(409);
// PUG_DEBUG:409
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(422);
// PUG_DEBUG:422
 ?><?php if (isset($__pug_mixins, $__pug_mixins['label'])) {
    $__pug_save_8786072 = $__pug_mixins['label'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['label'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'info', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(410);
// PUG_DEBUG:410
 ?><?php $checked = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(411);
// PUG_DEBUG:411
 ?><!--  TODO: fix active state // не добавляется класс, если изначально в данных нет поля checked --><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(421);
// PUG_DEBUG:421
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'label'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), ((isset($checked) ? $checked : null) ? 'label--checked' : '') ))], ['@click' => 'toggleChecked'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(419);
// PUG_DEBUG:419
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(412);
// PUG_DEBUG:412
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(413);
// PUG_DEBUG:413
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(414);
// PUG_DEBUG:414
 ?>

<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(417);
// PUG_DEBUG:417
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'count')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(416);
// PUG_DEBUG:416
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'label__count'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(415);
// PUG_DEBUG:415
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'count')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(418);
// PUG_DEBUG:418
 ?><!----><?php } ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(420);
// PUG_DEBUG:420
 ?></div><?php
}; ?><?php if (isset($__pug_save_8786072)) {
    $__pug_mixins['label'] = $__pug_save_8786072;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(438);
// PUG_DEBUG:438
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_9262963 = $__pug_mixins['btn'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['btn'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'tag', null], [false, 'text', null], [false, 'className', null], [false, 'disabled', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(427);
// PUG_DEBUG:427
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(426);
// PUG_DEBUG:426
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(423);
// PUG_DEBUG:423
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(425);
// PUG_DEBUG:425
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(424);
// PUG_DEBUG:424
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(432);
// PUG_DEBUG:432
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(431);
// PUG_DEBUG:431
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(428);
// PUG_DEBUG:428
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(430);
// PUG_DEBUG:430
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(429);
// PUG_DEBUG:429
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(437);
// PUG_DEBUG:437
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(433);
// PUG_DEBUG:433
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(435);
// PUG_DEBUG:435
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(434);
// PUG_DEBUG:434
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(436);
// PUG_DEBUG:436
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_9262963)) {
    $__pug_mixins['btn'] = $__pug_save_9262963;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(480);
// PUG_DEBUG:480
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(441);
// PUG_DEBUG:441
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-fade'])) {
    $__pug_save_3271720 = $__pug_mixins['animation-fade'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['animation-fade'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'duration', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(440);
// PUG_DEBUG:440
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(439);
// PUG_DEBUG:439
 ?></transition><?php
}; ?><?php if (isset($__pug_save_3271720)) {
    $__pug_mixins['animation-fade'] = $__pug_save_3271720;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(694);
// PUG_DEBUG:694
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(586);
// PUG_DEBUG:586
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(698);
// PUG_DEBUG:698
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(707);
// PUG_DEBUG:707
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(719);
// PUG_DEBUG:719
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(835);
// PUG_DEBUG:835
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(745);
// PUG_DEBUG:745
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(749);
// PUG_DEBUG:749
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_2322572 = $__pug_mixins['text'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['text'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'text', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(748);
// PUG_DEBUG:748
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(746);
// PUG_DEBUG:746
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(747);
// PUG_DEBUG:747
 ?></p><?php
}; ?><?php if (isset($__pug_save_2322572)) {
    $__pug_mixins['text'] = $__pug_save_2322572;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(761);
// PUG_DEBUG:761
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(777);
// PUG_DEBUG:777
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_5494589 = $__pug_mixins['btn'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['btn'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'tag', null], [false, 'text', null], [false, 'className', null], [false, 'disabled', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(766);
// PUG_DEBUG:766
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(765);
// PUG_DEBUG:765
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(762);
// PUG_DEBUG:762
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(764);
// PUG_DEBUG:764
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(763);
// PUG_DEBUG:763
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(771);
// PUG_DEBUG:771
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(770);
// PUG_DEBUG:770
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(767);
// PUG_DEBUG:767
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(769);
// PUG_DEBUG:769
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(768);
// PUG_DEBUG:768
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(776);
// PUG_DEBUG:776
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(772);
// PUG_DEBUG:772
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(774);
// PUG_DEBUG:774
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(773);
// PUG_DEBUG:773
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(775);
// PUG_DEBUG:775
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_5494589)) {
    $__pug_mixins['btn'] = $__pug_save_5494589;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(784);
// PUG_DEBUG:784
 ?><?php if (isset($__pug_mixins, $__pug_mixins['checkbox'])) {
    $__pug_save_7716241 = $__pug_mixins['checkbox'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['checkbox'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'obj', null], [false, 'className', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(783);
// PUG_DEBUG:783
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(778);
// PUG_DEBUG:778
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__input'], ['type' => 'checkbox'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked'))], ['v-model' => 'obj.checked'], ['@change' => '$emit(\'change\', obj.checked)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(779);
// PUG_DEBUG:779
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(782);
// PUG_DEBUG:782
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(780);
// PUG_DEBUG:780
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(781);
// PUG_DEBUG:781
 ?></span></label><?php
}; ?><?php if (isset($__pug_save_7716241)) {
    $__pug_mixins['checkbox'] = $__pug_save_7716241;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(815);
// PUG_DEBUG:815
 ?><?php if (isset($__pug_mixins, $__pug_mixins['picture'])) {
    $__pug_save_3960996 = $__pug_mixins['picture'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['picture'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
    $__pug_values = [];
    foreach ($__pug_arguments as $__pug_argument) {
        if ($__pug_argument[0]) {
            foreach ($__pug_argument[1] as $__pug_value) {
                $__pug_values[] = $__pug_value;
            }
            continue;
        }
        $__pug_values[] = $__pug_argument[1];
    }
    $__pug_attributes = [[false, 'data', null], [false, 'className', null], [false, 'optimize', null]];
    $__pug_names = [];
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        ${$__pug_name} = null;
    }
    foreach ($__pug_attributes as $__pug_argument) {
        $__pug_name = ltrim($__pug_argument[1], "$");
        $__pug_names[] = $__pug_name;
        if ($__pug_argument[0]) {
            ${$__pug_name} = $__pug_values;
            break;
        }
        ${$__pug_name} = array_shift($__pug_values);
        if (is_null(${$__pug_name}) && isset($__pug_argument[2])) {
            ${$__pug_name} = $__pug_argument[2];
        }
    }
    foreach ($__pug_mixin_vars as $__pug_key => &$__pug_value) {
        if (!in_array($__pug_key, $__pug_names)) {
            $$__pug_key = &$__pug_value;
        }
    }
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(799);
// PUG_DEBUG:799
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(798);
// PUG_DEBUG:798
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(787);
// PUG_DEBUG:787
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(786);
// PUG_DEBUG:786
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(785);
// PUG_DEBUG:785
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(788);
// PUG_DEBUG:788
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(791);
// PUG_DEBUG:791
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(790);
// PUG_DEBUG:790
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(789);
// PUG_DEBUG:789
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(792);
// PUG_DEBUG:792
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(795);
// PUG_DEBUG:795
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(794);
// PUG_DEBUG:794
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(793);
// PUG_DEBUG:793
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(796);
// PUG_DEBUG:796
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(797);
// PUG_DEBUG:797
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(814);
// PUG_DEBUG:814
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(802);
// PUG_DEBUG:802
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(801);
// PUG_DEBUG:801
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(800);
// PUG_DEBUG:800
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(803);
// PUG_DEBUG:803
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(806);
// PUG_DEBUG:806
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(805);
// PUG_DEBUG:805
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(804);
// PUG_DEBUG:804
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(807);
// PUG_DEBUG:807
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(810);
// PUG_DEBUG:810
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(809);
// PUG_DEBUG:809
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(808);
// PUG_DEBUG:808
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(811);
// PUG_DEBUG:811
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(812);
// PUG_DEBUG:812
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(813);
// PUG_DEBUG:813
 ?></picture><?php } ?><?php
}; ?><?php if (isset($__pug_save_3960996)) {
    $__pug_mixins['picture'] = $__pug_save_3960996;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(865);
// PUG_DEBUG:865
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixin_vars = [];
foreach (array_keys(get_defined_vars()) as $__local_pug_key) {
    if (mb_substr($__local_pug_key, 0, 6) === '__pug_' || in_array($__local_pug_key, ['attributes', 'block', 'pug_vars'])) {
        continue;
    }
    $pug_vars[$__local_pug_key] = &$$__local_pug_key;
    $__local_pug_ref = &$GLOBALS[$__local_pug_key];
    $__local_pug_value = &$$__local_pug_key;
    if($__local_pug_ref !== $__local_pug_value){
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
        continue;
    }
    $__local_pug_savedValue = $__local_pug_value;
    $__local_pug_value = ($__local_pug_value === true) ? false : true;
    $__local_pug_isGlobalReference = ($__local_pug_value === $__local_pug_ref);
    $__local_pug_value = $__local_pug_savedValue;
    if (!$__local_pug_isGlobalReference) {
        $__pug_mixin_vars[$__local_pug_key] = &$__local_pug_value;
    }
}
if (!isset($__pug_children)) {
    $__pug_children = null;
}
$__pug_mixin_name = 'detail-district';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($json) ? $json : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
    foreach (array_keys($__pug_children_vars) as $__local_pug_key) {
        if (mb_substr($__local_pug_key, 0, 6) === '__pug_') {
            continue;
        }
        if(isset($pug_vars[$__local_pug_key])){
            $$__local_pug_key = &$pug_vars[$__local_pug_key];
            continue;
        }
        $__local_pug_ref = &$GLOBALS[$__local_pug_key];
        $__local_pug_value = &$__pug_children_vars[$__local_pug_key];
        if($__local_pug_ref !== $__local_pug_value){
            $$__local_pug_key = &$__local_pug_value;
            continue;
        }
    }
    ?><?php
}); ?>