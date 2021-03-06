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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(111);
// PUG_DEBUG:111
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(110);
// PUG_DEBUG:110
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(99);
// PUG_DEBUG:99
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(98);
// PUG_DEBUG:98
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(97);
// PUG_DEBUG:97
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(100);
// PUG_DEBUG:100
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(103);
// PUG_DEBUG:103
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(102);
// PUG_DEBUG:102
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(101);
// PUG_DEBUG:101
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(104);
// PUG_DEBUG:104
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(107);
// PUG_DEBUG:107
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(106);
// PUG_DEBUG:106
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(105);
// PUG_DEBUG:105
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(108);
// PUG_DEBUG:108
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(109);
// PUG_DEBUG:109
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(126);
// PUG_DEBUG:126
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(114);
// PUG_DEBUG:114
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(113);
// PUG_DEBUG:113
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(112);
// PUG_DEBUG:112
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(115);
// PUG_DEBUG:115
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(118);
// PUG_DEBUG:118
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(117);
// PUG_DEBUG:117
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(116);
// PUG_DEBUG:116
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(119);
// PUG_DEBUG:119
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(122);
// PUG_DEBUG:122
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(121);
// PUG_DEBUG:121
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(120);
// PUG_DEBUG:120
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(123);
// PUG_DEBUG:123
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(124);
// PUG_DEBUG:124
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(125);
// PUG_DEBUG:125
 ?></picture><?php } ?><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(130);
// PUG_DEBUG:130
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(129);
// PUG_DEBUG:129
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(128);
// PUG_DEBUG:128
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(133);
// PUG_DEBUG:133
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(131);
// PUG_DEBUG:131
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(132);
// PUG_DEBUG:132
 ?></div><?php } ?><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-fifth'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(137);
// PUG_DEBUG:137
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fifth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(135);
// PUG_DEBUG:135
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(136);
// PUG_DEBUG:136
 ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['banner-home'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(149);
// PUG_DEBUG:149
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-home'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(140);
// PUG_DEBUG:140
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'background')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(139);
// PUG_DEBUG:139
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'background')], [false, 'banner-home__background']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(141);
// PUG_DEBUG:141
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(148);
// PUG_DEBUG:148
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-home__content'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(143);
// PUG_DEBUG:143
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(142);
// PUG_DEBUG:142
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')], [false, 'banner-home__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(144);
// PUG_DEBUG:144
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(146);
// PUG_DEBUG:146
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(145);
// PUG_DEBUG:145
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
$__pug_mixin_name = 'title-fifth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')], [false, 'banner-home__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(147);
// PUG_DEBUG:147
 ?><!----><?php } ?></div></div><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(157);
// PUG_DEBUG:157
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-radio'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($buttons) ? $buttons : null), 'length') >= 3 ? 'filter-radio--big' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(156);
// PUG_DEBUG:156
 ?><?php foreach ($buttons as $radio) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(155);
// PUG_DEBUG:155
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-radio__item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(151);
// PUG_DEBUG:151
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'radio'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', (isset($name) ? $name : null))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($radio) ? $radio : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($radio) ? $radio : null), 'checked'))], ['v-model' => 'checked'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(154);
// PUG_DEBUG:154
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-radio__label'], ['@click' => 'checked = radio.value, $emit(\'change\', checked, name)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(152);
// PUG_DEBUG:152
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($radio) ? $radio : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(153);
// PUG_DEBUG:153
 ?></label></div><?php } ?></div><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(160);
// PUG_DEBUG:160
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(159);
// PUG_DEBUG:159
 ?></transition><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(167);
// PUG_DEBUG:167
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(162);
// PUG_DEBUG:162
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__input'], ['type' => 'checkbox'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked'))], ['v-model' => 'obj.checked'], ['@change' => '$emit(\'change\', obj.checked)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(163);
// PUG_DEBUG:163
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(166);
// PUG_DEBUG:166
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(164);
// PUG_DEBUG:164
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(165);
// PUG_DEBUG:165
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(169);
// PUG_DEBUG:169
 ?><?php $selected = array( 'text' => '' ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(170);
// PUG_DEBUG:170
 ?><?php $isOpen = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(196);
// PUG_DEBUG:196
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), array( 'select--open' => (isset($isOpen) ? $isOpen : null) ), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple') ? 'select--multiple' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(179);
// PUG_DEBUG:179
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head'], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') : ''))], ['ref' => 'head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(173);
// PUG_DEBUG:173
 ?><?php if ((isset($title) ? $title : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(172);
// PUG_DEBUG:172
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__pre-title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(171);
// PUG_DEBUG:171
 ?><?= (is_bool($_pug_temp = (isset($title) ? $title : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(174);
// PUG_DEBUG:174
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(176);
// PUG_DEBUG:176
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(175);
// PUG_DEBUG:175
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($selected) ? $selected : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(178);
// PUG_DEBUG:178
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head-ico'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(177);
// PUG_DEBUG:177
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(195);
// PUG_DEBUG:195
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(193);
// PUG_DEBUG:193
 ?><?php if (((isset($isOpen) ? $isOpen : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(192);
// PUG_DEBUG:192
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__dropdown'], ['ref' => 'dropdown'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(186);
// PUG_DEBUG:186
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(185);
// PUG_DEBUG:185
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(184);
// PUG_DEBUG:184
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(183);
// PUG_DEBUG:183
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( array( 'select__li--active' => (function_exists('computedClass') ? computedClass((isset($item) ? $item : null)) : call_user_func((isset($computedClass) ? $computedClass : null), (isset($item) ? $item : null))) ), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled') ? 'select__li--disabled' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(181);
// PUG_DEBUG:181
 ?><?php if ((!call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(180);
// PUG_DEBUG:180
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(182);
// PUG_DEBUG:182
 ?><!----><?php } ?></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(191);
// PUG_DEBUG:191
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(190);
// PUG_DEBUG:190
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(189);
// PUG_DEBUG:189
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['@click' => 'change(item)'], [':class' => '{&quot;select__li--active&quot; : computedClass(item)}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(188);
// PUG_DEBUG:188
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(187);
// PUG_DEBUG:187
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(194);
// PUG_DEBUG:194
 ?><!----><?php } ?><?php
}); ?></div><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(202);
// PUG_DEBUG:202
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(201);
// PUG_DEBUG:201
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(198);
// PUG_DEBUG:198
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(200);
// PUG_DEBUG:200
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(199);
// PUG_DEBUG:199
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(207);
// PUG_DEBUG:207
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(206);
// PUG_DEBUG:206
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(203);
// PUG_DEBUG:203
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(205);
// PUG_DEBUG:205
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(204);
// PUG_DEBUG:204
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(212);
// PUG_DEBUG:212
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(208);
// PUG_DEBUG:208
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(210);
// PUG_DEBUG:210
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(209);
// PUG_DEBUG:209
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(211);
// PUG_DEBUG:211
 ?></a><?php } ?><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(214);
// PUG_DEBUG:214
 ?><?php $checked = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(215);
// PUG_DEBUG:215
 ?><!--  TODO: fix active state // не добавляется класс, если изначально в данных нет поля checked --><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(225);
// PUG_DEBUG:225
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'label'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), ((isset($checked) ? $checked : null) ? 'label--checked' : '') ))], ['@click' => 'toggleChecked'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(223);
// PUG_DEBUG:223
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(216);
// PUG_DEBUG:216
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(217);
// PUG_DEBUG:217
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(218);
// PUG_DEBUG:218
 ?>

<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(221);
// PUG_DEBUG:221
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'count')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(220);
// PUG_DEBUG:220
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'label__count'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(219);
// PUG_DEBUG:219
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'count')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(222);
// PUG_DEBUG:222
 ?><!----><?php } ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(224);
// PUG_DEBUG:224
 ?></div><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(266);
// PUG_DEBUG:266
 ?><?php $showDropdown = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(267);
// PUG_DEBUG:267
 ?><?php $dropdown = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(268);
// PUG_DEBUG:268
 ?><?php $range = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'range') ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(269);
// PUG_DEBUG:269
 ?><?php $title = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'inputs', 'title') ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(303);
// PUG_DEBUG:303
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'range') ? 'filter-range--big' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(295);
// PUG_DEBUG:295
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(294);
// PUG_DEBUG:294
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__inputs'], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (isset($title) ? $title : null))], ['ref' => 'head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(273);
// PUG_DEBUG:273
 ?><?php if (((isset($name) ? $name : null) === 'price')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(272);
// PUG_DEBUG:272
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__inputs-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(270);
// PUG_DEBUG:270
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'value'))], ['@keyup' => 'formatPrice($event, info.inputs.min)'], ['v-model' => 'formData[info.inputs.min.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(271);
// PUG_DEBUG:271
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'value'))], ['@keyup' => 'formatPrice($event, info.inputs.max)'], ['v-model' => 'formData[info.inputs.max.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(276);
// PUG_DEBUG:276
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__inputs-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(274);
// PUG_DEBUG:274
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'min', 'value'))], ['v-model' => 'formData[info.inputs.min.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(275);
// PUG_DEBUG:275
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'text'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'name'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'placeholder'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'inputs', 'max', 'value'))], ['v-model' => 'formData[info.inputs.max.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(292);
// PUG_DEBUG:292
 }  if (((isset($dropdown) ? $dropdown : null) && (isset($showDropdown) ? $showDropdown : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(291);
// PUG_DEBUG:291
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown'], ['ref' => 'drop'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(282);
// PUG_DEBUG:282
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($dropdown) ? $dropdown : null), 'min'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(281);
// PUG_DEBUG:281
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(280);
// PUG_DEBUG:280
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $dropdown, 'min') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(279);
// PUG_DEBUG:279
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-li'], ['@click' => 'change(item, \'min\')'], [':class' => '{&quot;filter-range__dropdown-li--active&quot; : computedClass(item, \'min\')}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(278);
// PUG_DEBUG:278
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(277);
// PUG_DEBUG:277
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(283);
// PUG_DEBUG:283
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(289);
// PUG_DEBUG:289
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($dropdown) ? $dropdown : null), 'max'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(288);
// PUG_DEBUG:288
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(287);
// PUG_DEBUG:287
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $dropdown, 'max') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(286);
// PUG_DEBUG:286
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-range__dropdown-li'], ['@click' => 'change(item, \'max\')'], [':class' => '{&quot;filter-range__dropdown-li--active&quot; : computedClass(item, \'max\')}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(285);
// PUG_DEBUG:285
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(284);
// PUG_DEBUG:284
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(290);
// PUG_DEBUG:290
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(293);
// PUG_DEBUG:293
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(296);
// PUG_DEBUG:296
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(298);
// PUG_DEBUG:298
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'currency')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(297);
// PUG_DEBUG:297
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(299);
// PUG_DEBUG:299
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(301);
// PUG_DEBUG:301
 }  if ((isset($range) ? $range : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(300);
// PUG_DEBUG:300
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(302);
// PUG_DEBUG:302
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(310);
// PUG_DEBUG:310
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(309);
// PUG_DEBUG:309
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(315);
// PUG_DEBUG:315
 ?><?php $hints = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(352);
// PUG_DEBUG:352
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), array( 'hint--open' => (isset($isOpen) ? $isOpen : null) ) ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(325);
// PUG_DEBUG:325
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__head'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title') ? '' : 'hint__head--base'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(318);
// PUG_DEBUG:318
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(317);
// PUG_DEBUG:317
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(316);
// PUG_DEBUG:316
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(319);
// PUG_DEBUG:319
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(321);
// PUG_DEBUG:321
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__close'], ['@click' => 'closeDropDown()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(320);
// PUG_DEBUG:320
 ?><span></span></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(323);
// PUG_DEBUG:323
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'input')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(322);
// PUG_DEBUG:322
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__input'], ['type' => 'text'], ['v-model' => 'value'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'input', 'value'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'input', 'placeholder'))], ['autocomplete' => 'off'], ['@input' => 'getTips'], ['@change' => 'confirmValue()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(324);
// PUG_DEBUG:324
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(350);
// PUG_DEBUG:350
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($hints) ? $hints : null), 'length')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(349);
// PUG_DEBUG:349
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(348);
// PUG_DEBUG:348
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown'], ['v-if' => 'isOpen'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(347);
// PUG_DEBUG:347
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown-content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(345);
// PUG_DEBUG:345
 ?><?php if ((isset($hints) ? $hints : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(344);
// PUG_DEBUG:344
 ?><?php foreach ($hints as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(343);
// PUG_DEBUG:343
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown-item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(337);
// PUG_DEBUG:337
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(336);
// PUG_DEBUG:336
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__dropdown-head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(332);
// PUG_DEBUG:332
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'icon')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(331);
// PUG_DEBUG:331
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(327);
// PUG_DEBUG:327
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'icon') === 'pin2') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(326);
// PUG_DEBUG:326
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/pin2.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/pin2.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(329);
// PUG_DEBUG:329
 }  elseif(call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'icon') === 'sity') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(328);
// PUG_DEBUG:328
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/sity.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/sity.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(330);
// PUG_DEBUG:330
 ?><!----><?php } ?></svg><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(333);
// PUG_DEBUG:333
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(335);
// PUG_DEBUG:335
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(334);
// PUG_DEBUG:334
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'head', 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(338);
// PUG_DEBUG:338
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(342);
// PUG_DEBUG:342
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__list'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(341);
// PUG_DEBUG:341
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'items') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(340);
// PUG_DEBUG:340
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'hint__list-item'], ['class' => 'text'], ['@click' => 'change(el)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(339);
// PUG_DEBUG:339
 ?><?= (is_bool($_pug_temp = (isset($el) ? $el : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></li><?php } ?></ul></div><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(346);
// PUG_DEBUG:346
 ?><!----><?php } ?></div></div><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(351);
// PUG_DEBUG:351
 ?><!----><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['filter-catalog'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'info', null], [false, 'className', null], [false, 'mainFilter', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(354);
// PUG_DEBUG:354
 ?><?php $showMore = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(355);
// PUG_DEBUG:355
 ?><?php $special = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'tags') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'tags', 'special') : false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(356);
// PUG_DEBUG:356
 ?><?php $fieldsConds = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'fields') ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(357);
// PUG_DEBUG:357
 ?><?php $fieldsCondsMore = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'more') ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(358);
// PUG_DEBUG:358
 ?><?php $visibleTags = null ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(422);
// PUG_DEBUG:422
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), (call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'type'))) ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(373);
// PUG_DEBUG:373
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(372);
// PUG_DEBUG:372
 ?><?php foreach ($fieldsConds as $field) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(371);
// PUG_DEBUG:371
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__group'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__group--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type')), call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__group--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')), call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__group--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name'), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'values') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'values', 'length') === 3 ? '-tripple' : '')), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'style') ? call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__group--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'style')) : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(360);
// PUG_DEBUG:360
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'hidden')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(359);
// PUG_DEBUG:359
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'hidden'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'value'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(362);
// PUG_DEBUG:362
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'radio')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(361);
// PUG_DEBUG:361
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@change' => 'setFieldData']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'values')], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')], [false, 'filter-catalog__radio'], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'name')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(365);
// PUG_DEBUG:365
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'select')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(364);
// PUG_DEBUG:364
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__group-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(363);
// PUG_DEBUG:363
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@input' => 'setFieldData']), [[false, (isset($field) ? $field : null)], [false, call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__select filter-catalog__select--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name'))], [false, '0.3']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(367);
// PUG_DEBUG:367
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'range')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(366);
// PUG_DEBUG:366
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@change' => 'setRange']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'range')], [false, (call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__range filter-catalog__range--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')))], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'name')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(369);
// PUG_DEBUG:369
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'input' && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name') === 'search')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(368);
// PUG_DEBUG:368
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@passHint' => 'setFieldData']), [[false, (isset($field) ? $field : null)], [false, 'filter-address filter-catalog__address']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(370);
// PUG_DEBUG:370
 ?><!----><?php } ?></div><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(385);
// PUG_DEBUG:385
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'more'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(384);
// PUG_DEBUG:384
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(383);
// PUG_DEBUG:383
 ?><?php if (((isset($showMore) ? $showMore : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(382);
// PUG_DEBUG:382
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__hidden'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(381);
// PUG_DEBUG:381
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__main'], ['class' => 'filter-catalog__main--hidden'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__main--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'name')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(380);
// PUG_DEBUG:380
 ?><?php foreach ($fieldsCondsMore as $field) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(379);
// PUG_DEBUG:379
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__group'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__group--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type')), call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__group--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'disabled') ? 'filter-catalog__group--hide' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(375);
// PUG_DEBUG:375
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'select')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(374);
// PUG_DEBUG:374
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@input' => 'setFieldData']), [[false, (isset($field) ? $field : null)], [false, call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__select filter-catalog__select--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name'))], [false, '0.3']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(377);
// PUG_DEBUG:377
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'type') === 'range')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(376);
// PUG_DEBUG:376
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@change' => 'setRange']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'range')], [false, call_user_func($GLOBALS['__jpv_plus'], 'filter-catalog__range filter-catalog__range--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name'))], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($field) ? $field : null), 'name')], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'name')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(378);
// PUG_DEBUG:378
 ?><!----><?php } ?></div><?php } ?></div></div><?php } ?><?php
}); ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(386);
// PUG_DEBUG:386
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(415);
// PUG_DEBUG:415
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__buttons'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(405);
// PUG_DEBUG:405
 ?><?php if (((isset($visibleButtons) ? $visibleButtons : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($visibleButtons) ? $visibleButtons : null), 'length') !== 0 || (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'tags') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'tags', 'special')))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(404);
// PUG_DEBUG:404
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__popup-btns'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(396);
// PUG_DEBUG:396
 ?><?php if (((isset($visibleButtons) ? $visibleButtons : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($visibleButtons) ? $visibleButtons : null), 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(395);
// PUG_DEBUG:395
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__popup-btns-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(394);
// PUG_DEBUG:394
 ?><?php foreach ($visibleButtons as $btn) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(393);
// PUG_DEBUG:393
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__popup-btn'], ['@click' => 'openPopup(btn)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(388);
// PUG_DEBUG:388
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(387);
// PUG_DEBUG:387
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(391);
// PUG_DEBUG:391
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(390);
// PUG_DEBUG:390
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__popup-btn-count'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(389);
// PUG_DEBUG:389
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(392);
// PUG_DEBUG:392
 ?><!----><?php } ?></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(397);
// PUG_DEBUG:397
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(402);
// PUG_DEBUG:402
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'tags') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'tags', 'special'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(401);
// PUG_DEBUG:401
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__tags'], ['class' => 'filter-catalog__tags--filter'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(400);
// PUG_DEBUG:400
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__tags-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(399);
// PUG_DEBUG:399
 ?><?php foreach ($special as $tag) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(398);
// PUG_DEBUG:398
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes']([':key' => 'tag.value'], ['@change' => 'setTag(tag)']), [[false, (isset($tag) ? $tag : null)], [false, 'label--black filter-catalog__tag filter-catalog__tag--rect']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(403);
// PUG_DEBUG:403
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(406);
// PUG_DEBUG:406
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(413);
// PUG_DEBUG:413
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__form-buttons'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(408);
// PUG_DEBUG:408
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__form-reset'], ['@click' => 'resetFilter'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(407);
// PUG_DEBUG:407
 ?>Сбросить</div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(411);
// PUG_DEBUG:411
 ?><?php if (((isset($fieldsCondsMore) ? $fieldsCondsMore : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($fieldsCondsMore) ? $fieldsCondsMore : null), 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(410);
// PUG_DEBUG:410
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__more'], ['@click' => 'showMore = !showMore'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($showMore) ? $showMore : null) ? 'filter-catalog__more--open' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(409);
// PUG_DEBUG:409
 ?><?= (is_bool($_pug_temp = ((isset($showMore) ? $showMore : null) ? 'Скрыть фильтры' : 'Еще фильтры')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(412);
// PUG_DEBUG:412
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(414);
// PUG_DEBUG:414
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@click' => 'submitEventDebounce']), [[false, 'button'], [false, 'Показать'], [false, 'filter-catalog__submit']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(420);
// PUG_DEBUG:420
 ?><?php if (((isset($visibleTags) ? $visibleTags : null) && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($visibleTags) ? $visibleTags : null), 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(419);
// PUG_DEBUG:419
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__tags'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(418);
// PUG_DEBUG:418
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-catalog__tags-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(417);
// PUG_DEBUG:417
 ?><?php foreach ($visibleTags as $tag) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(416);
// PUG_DEBUG:416
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes']([':key' => 'tag.value'], ['@change' => 'setTag(tag)']), [[false, (isset($tag) ? $tag : null)], [false, 'filter-catalog__tag']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(421);
// PUG_DEBUG:421
 ?><!----><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['filter-home'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(463);
// PUG_DEBUG:463
 ?><?php $activeTab = '' ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(464);
// PUG_DEBUG:464
 ?><?php $tags = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(500);
// PUG_DEBUG:500
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(491);
// PUG_DEBUG:491
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'tabs'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(490);
// PUG_DEBUG:490
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__form'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(471);
// PUG_DEBUG:471
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'select') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'select', 'values'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(470);
// PUG_DEBUG:470
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__select-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(465);
// PUG_DEBUG:465
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@input' => 'changeTab']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'select')], [false, 'filter-home__tab-select'], [false, '0.3']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(469);
// PUG_DEBUG:469
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__tabs'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(468);
// PUG_DEBUG:468
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'select', 'values') as $btn) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(467);
// PUG_DEBUG:467
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__tab-btn'], ['@click' => 'changeTab(btn.value, btn.value, btn.disabled)'], ['style' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('style', call_user_func($GLOBALS['__jpv_plus'], 'width: calc(100% / ', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'select', 'values', 'length'), ')'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($activeTab) ? $activeTab : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'value') ? 'filter-home__tab-btn--active' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(466);
// PUG_DEBUG:466
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } ?></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(472);
// PUG_DEBUG:472
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(489);
// PUG_DEBUG:489
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__form-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(477);
// PUG_DEBUG:477
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'tabs') as $tab) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(476);
// PUG_DEBUG:476
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__tab'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(474);
// PUG_DEBUG:474
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($tab) ? $tab : null), 'name') === (isset($activeTab) ? $activeTab : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(473);
// PUG_DEBUG:473
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
$__pug_mixin_name = 'filter-catalog';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@filterSubmit' => 'submitFilter']), [[false, (isset($tab) ? $tab : null)], [false, 'filter-home__filter'], [false, true]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(475);
// PUG_DEBUG:475
 ?><!----><?php } ?></div><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(488);
// PUG_DEBUG:488
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__bottom'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(482);
// PUG_DEBUG:482
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'tags'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(481);
// PUG_DEBUG:481
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__tags'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(480);
// PUG_DEBUG:480
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__tags-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(479);
// PUG_DEBUG:479
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'tags', 'list') as $index => $tag) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(478);
// PUG_DEBUG:478
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes']([':key' => 'tag.value'], ['@change' => 'openTag(tag)']), [[false, (isset($tag) ? $tag : null)], [false, 'filter-home__tag']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(483);
// PUG_DEBUG:483
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(486);
// PUG_DEBUG:486
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'broker'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(485);
// PUG_DEBUG:485
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__broker'], ['@click' => 'openPopup(\'form\', \'brokerSelection\', info.typeEstate)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(484);
// PUG_DEBUG:484
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'broker')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(487);
// PUG_DEBUG:487
 ?><!----><?php } ?></div></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(492);
// PUG_DEBUG:492
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(498);
// PUG_DEBUG:498
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'mapBtn')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(497);
// PUG_DEBUG:497
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'filter-home__map-btn'], ['href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'mapBtn', 'url'))], ['style' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('style', call_user_func($GLOBALS['__jpv_plus'], 'background-image: url(', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'mapBtn', 'img'), ')'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(494);
// PUG_DEBUG:494
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(493);
// PUG_DEBUG:493
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/pin.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/pin.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(496);
// PUG_DEBUG:496
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(495);
// PUG_DEBUG:495
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'mapBtn', 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(499);
// PUG_DEBUG:499
 ?><!----><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-fourth'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'text', null], [false, 'className', null], [false, 'isH1', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(504);
// PUG_DEBUG:504
 ?><?php if ((isset($isH1) ? $isH1 : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(503);
// PUG_DEBUG:503
 ?><h1<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fourth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(502);
// PUG_DEBUG:502
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></h1><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(507);
// PUG_DEBUG:507
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fourth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(505);
// PUG_DEBUG:505
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(506);
// PUG_DEBUG:506
 ?></div><?php } ?><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(511);
// PUG_DEBUG:511
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(509);
// PUG_DEBUG:509
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(510);
// PUG_DEBUG:510
 ?></p><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home-types'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(539);
// PUG_DEBUG:539
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(523);
// PUG_DEBUG:523
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'items') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(522);
// PUG_DEBUG:522
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__item'], ['style' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('style', call_user_func($GLOBALS['__jpv_plus'], 'background-image: url(', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'img'), ')'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(521);
// PUG_DEBUG:521
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__item-content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(515);
// PUG_DEBUG:515
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'titleLink')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(514);
// PUG_DEBUG:514
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__title'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'titleLink', 'href'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(513);
// PUG_DEBUG:513
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'titleLink', 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(516);
// PUG_DEBUG:516
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(520);
// PUG_DEBUG:520
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__links'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(519);
// PUG_DEBUG:519
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'items') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(518);
// PUG_DEBUG:518
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(517);
// PUG_DEBUG:517
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></a><?php } ?></div></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(537);
// PUG_DEBUG:537
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'offer'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(536);
// PUG_DEBUG:536
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__item'], ['class' => 'home-types__item--offer'], ['@click' => 'popupOpen(\'form\', obj.offer.popup)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(533);
// PUG_DEBUG:533
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__item-content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(525);
// PUG_DEBUG:525
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'offer', 'title')) { ?><?php 
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
$__pug_mixin_name = 'title-fourth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'offer', 'title')], [false, 'title-fourth--up home-types__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(526);
// PUG_DEBUG:526
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(528);
// PUG_DEBUG:528
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'offer', 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(527);
// PUG_DEBUG:527
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'offer', 'text')], [false, 'home-types__item-text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(529);
// PUG_DEBUG:529
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(532);
// PUG_DEBUG:532
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__item-icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(531);
// PUG_DEBUG:531
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(530);
// PUG_DEBUG:530
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right2.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right2.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(535);
// PUG_DEBUG:535
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-types__item-giraffe'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(534);
// PUG_DEBUG:534
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/giraffe.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/giraffe.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(538);
// PUG_DEBUG:538
 ?><!----><?php } ?></div><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(543);
// PUG_DEBUG:543
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-second'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(541);
// PUG_DEBUG:541
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(542);
// PUG_DEBUG:542
 ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home-how'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(623);
// PUG_DEBUG:623
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(581);
// PUG_DEBUG:581
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'picture')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(580);
// PUG_DEBUG:580
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'picture')], [false, 'home-how__img'], [false, 'lazyload']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(582);
// PUG_DEBUG:582
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(622);
// PUG_DEBUG:622
 ?><form<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__content'], ['action' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('action', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(611);
// PUG_DEBUG:611
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success') && !call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success', 'show'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(610);
// PUG_DEBUG:610
 ?><div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(601);
// PUG_DEBUG:601
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__items'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(600);
// PUG_DEBUG:600
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'tabs') as $i => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(599);
// PUG_DEBUG:599
 ?><div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(597);
// PUG_DEBUG:597
 ?><?php if (((isset($i) ? $i : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'active'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(596);
// PUG_DEBUG:596
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(584);
// PUG_DEBUG:584
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(583);
// PUG_DEBUG:583
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'title')], [false, 'home-how__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(585);
// PUG_DEBUG:585
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(587);
// PUG_DEBUG:587
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(586);
// PUG_DEBUG:586
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')], [false, 'home-how__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(588);
// PUG_DEBUG:588
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(595);
// PUG_DEBUG:595
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__answers'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(594);
// PUG_DEBUG:594
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'answers') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(593);
// PUG_DEBUG:593
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__answer'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(589);
// PUG_DEBUG:589
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => 'radio'], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'value'))], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'name'))], ['@change' => 'changeQuestion(i)'], ['v-model' => 'formData[el.name]'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(592);
// PUG_DEBUG:592
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__answer-content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(591);
// PUG_DEBUG:591
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(590);
// PUG_DEBUG:590
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></div></label><?php } ?></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(598);
// PUG_DEBUG:598
 ?><!----><?php } ?></div><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(609);
// PUG_DEBUG:609
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__pag'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(602);
// PUG_DEBUG:602
 ?>Вопрос<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(603);
// PUG_DEBUG:603
 ?>

&nbsp;<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(605);
// PUG_DEBUG:605
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(604);
// PUG_DEBUG:604
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_plus'], call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'active'), 1)) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(606);
// PUG_DEBUG:606
 ?>&nbsp;из <?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(607);
// PUG_DEBUG:607
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'tabs', 'length')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(608);
// PUG_DEBUG:608
 ?>

</div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(612);
// PUG_DEBUG:612
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(620);
// PUG_DEBUG:620
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success', 'show'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(619);
// PUG_DEBUG:619
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-how__success'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(614);
// PUG_DEBUG:614
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success', 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(613);
// PUG_DEBUG:613
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success', 'title')], [false, 'home-how__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(615);
// PUG_DEBUG:615
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(617);
// PUG_DEBUG:617
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success', 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(616);
// PUG_DEBUG:616
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'success', 'text')], [false, 'home-how__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(618);
// PUG_DEBUG:618
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(621);
// PUG_DEBUG:621
 ?><!----><?php } ?></form></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home-experience'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(699);
// PUG_DEBUG:699
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-experience'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(688);
// PUG_DEBUG:688
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'picture')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(687);
// PUG_DEBUG:687
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'picture')], [false, 'home-experience__background'], [false, 'lazyload']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(698);
// PUG_DEBUG:698
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-experience__content'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(691);
// PUG_DEBUG:691
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(690);
// PUG_DEBUG:690
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-experience__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(689);
// PUG_DEBUG:689
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(693);
// PUG_DEBUG:693
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'mainTitle')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(692);
// PUG_DEBUG:692
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'mainTitle')], [false, 'title--m home-experience__main-title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(695);
// PUG_DEBUG:695
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(694);
// PUG_DEBUG:694
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')], [false, 'home-experience__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(697);
// PUG_DEBUG:697
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'btn')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(696);
// PUG_DEBUG:696
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'btn', 'url')], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'btn', 'text')], [false, 'btn--transparent btn--white home-experience__btn']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['services-item'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'info', null], [false, 'className', null], [false, 'isLazy', null]];
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
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'services-item'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(731);
// PUG_DEBUG:731
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'link'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(730);
// PUG_DEBUG:730
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'services-item__link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'link'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(733);
// PUG_DEBUG:733
 }  elseif((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'popup'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(732);
// PUG_DEBUG:732
 ?><button<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'services-item__link'], ['type' => 'button'], ['@click' => 'openPopup()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(734);
// PUG_DEBUG:734
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(736);
// PUG_DEBUG:736
 }  if ((isset($isLazy) ? $isLazy : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(735);
// PUG_DEBUG:735
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'services-item__img'], ['class' => 'lazyload'], ['data-src' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'ico'))], ['alt' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(737);
// PUG_DEBUG:737
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'services-item__img'], ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'ico'))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(738);
// PUG_DEBUG:738
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
$__pug_mixin_name = 'title-fourth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')], [false, 'title-fourth--up services-item__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(739);
// PUG_DEBUG:739
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'text')], [false, 'services-item__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['tabs'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'btns', null], [false, 'className', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(752);
// PUG_DEBUG:752
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tabs'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(751);
// PUG_DEBUG:751
 ?><?php foreach ($btns as $btn) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(750);
// PUG_DEBUG:750
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tabs__btn'], ['@click' => 'switchBtn(btn.value)'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($activeBtn) ? $activeBtn : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'value') ? 'tabs__btn--active' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(742);
// PUG_DEBUG:742
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(743);
// PUG_DEBUG:743
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(744);
// PUG_DEBUG:744
 ?>

<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(747);
// PUG_DEBUG:747
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(746);
// PUG_DEBUG:746
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(745);
// PUG_DEBUG:745
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_plus'], ' ', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count'))) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(748);
// PUG_DEBUG:748
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(749);
// PUG_DEBUG:749
 ?></div><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home-services'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(777);
// PUG_DEBUG:777
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(759);
// PUG_DEBUG:759
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'head')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(758);
// PUG_DEBUG:758
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(755);
// PUG_DEBUG:755
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'head', 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(754);
// PUG_DEBUG:754
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'head', 'title')], [false, 'home-services__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(757);
// PUG_DEBUG:757
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'head', 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(756);
// PUG_DEBUG:756
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'head', 'text')], [false, 'home-services__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></div><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(776);
// PUG_DEBUG:776
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(769);
// PUG_DEBUG:769
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__tabs-wrap'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(761);
// PUG_DEBUG:761
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'tabs')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(760);
// PUG_DEBUG:760
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
$__pug_mixin_name = 'tabs';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@changeTab' => 'changeTab']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'tabs')], [false, 'home-services__tabs']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(768);
// PUG_DEBUG:768
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__arrows'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(764);
// PUG_DEBUG:764
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__arrow'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($isBeginning) ? $isBeginning : null) === true ? 'swiper-button-disabled' : ''))], ['@click' => 'slider.slidePrev()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(763);
// PUG_DEBUG:763
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(762);
// PUG_DEBUG:762
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-left.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-left.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(767);
// PUG_DEBUG:767
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__arrow'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($isEnd) ? $isEnd : null) === true ? 'swiper-button-disabled' : ''))], ['@click' => 'slider.slideNext()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(766);
// PUG_DEBUG:766
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(765);
// PUG_DEBUG:765
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right2.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right2.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></a></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(775);
// PUG_DEBUG:775
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__sliders-wrap'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(774);
// PUG_DEBUG:774
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'sliders') as $i => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(773);
// PUG_DEBUG:773
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-services__slider'], ['class' => 'swiper-container'], ['v-if' => 'activeTab === item.name'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(772);
// PUG_DEBUG:772
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-wrapper'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(771);
// PUG_DEBUG:771
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'items') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(770);
// PUG_DEBUG:770
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
$__pug_mixin_name = 'services-item';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($el) ? $el : null)], [false, 'home-services__slide swiper-slide'], [false, true]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></div></div><?php } ?></div></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home-agency'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(851);
// PUG_DEBUG:851
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(823);
// PUG_DEBUG:823
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(820);
// PUG_DEBUG:820
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__head-left'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(819);
// PUG_DEBUG:819
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(818);
// PUG_DEBUG:818
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
$__pug_mixin_name = 'title-fifth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')], [false, 'title-fifth--up home-agency__head-title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(822);
// PUG_DEBUG:822
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(821);
// PUG_DEBUG:821
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')], [false, 'home-agency__head-text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(848);
// PUG_DEBUG:848
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__slider-wrap'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(829);
// PUG_DEBUG:829
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__slider'], ['class' => 'swiper-container'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(828);
// PUG_DEBUG:828
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-wrapper'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(827);
// PUG_DEBUG:827
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'slider') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(826);
// PUG_DEBUG:826
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__slide'], ['class' => 'swiper-slide'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(825);
// PUG_DEBUG:825
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'picture')) { ?><?php 
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
$__pug_mixin_name = 'picture';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'picture')], [false, 'home-agency__slide-img'], [false, 'lazyload']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></a><?php } ?></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(839);
// PUG_DEBUG:839
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__slider-description'], ['class' => 'swiper-container'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(838);
// PUG_DEBUG:838
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-wrapper'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(837);
// PUG_DEBUG:837
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'slider') as $i => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(836);
// PUG_DEBUG:836
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__slide-description'], ['class' => 'swiper-slide'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($i) ? $i : null) === 0 ? 'swiper-slide-active' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(830);
// PUG_DEBUG:830
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__slide-link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(832);
// PUG_DEBUG:832
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'name')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(831);
// PUG_DEBUG:831
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
$__pug_mixin_name = 'title-fifth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'name')], [false, 'title-fifth--up home-agency__slide-title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(835);
// PUG_DEBUG:835
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'price')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(834);
// PUG_DEBUG:834
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__slide-price'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(833);
// PUG_DEBUG:833
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'price')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } ?></div><?php } ?></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(847);
// PUG_DEBUG:847
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__nav'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(842);
// PUG_DEBUG:842
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__arrow'], ['class' => 'home-agency__arrow--prev'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(841);
// PUG_DEBUG:841
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(840);
// PUG_DEBUG:840
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-left.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-left.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(843);
// PUG_DEBUG:843
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__pag'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(846);
// PUG_DEBUG:846
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__arrow'], ['class' => 'home-agency__arrow--next'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(845);
// PUG_DEBUG:845
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(844);
// PUG_DEBUG:844
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right2.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right2.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></a></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(850);
// PUG_DEBUG:850
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-agency__back-icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(849);
// PUG_DEBUG:849
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/continent.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/continent.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(887);
// PUG_DEBUG:887
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery'], ['class' => 'swiper-container'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(872);
// PUG_DEBUG:872
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__pagination'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($paginationClass) ? $paginationClass : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(880);
// PUG_DEBUG:880
 ?><?php if (((isset($isPrev) ? $isPrev : null) === true && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($slides) ? $slides : null), 'length') > 1)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(879);
// PUG_DEBUG:879
 ?><div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(875);
// PUG_DEBUG:875
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__btn'], ['class' => 'swiper-button-prev'], ['@click.stop' => 'prev'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(874);
// PUG_DEBUG:874
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(873);
// PUG_DEBUG:873
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => '/assets/sprite.svg#arrow-left'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(878);
// PUG_DEBUG:878
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__btn'], ['class' => 'swiper-button-next'], ['@click.stop' => 'next'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(877);
// PUG_DEBUG:877
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(876);
// PUG_DEBUG:876
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => '/assets/sprite.svg#arrow-right2'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(881);
// PUG_DEBUG:881
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(886);
// PUG_DEBUG:886
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-wrapper'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(885);
// PUG_DEBUG:885
 ?><?php foreach ($slides as $slide) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(884);
// PUG_DEBUG:884
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-slide'], ['class' => 'card-gallery__slide'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(882);
// PUG_DEBUG:882
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-gallery__image'], ['class' => 'lazyload'], ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', (isset($slide) ? $slide : null))], ['alt' => ''])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(883);
// PUG_DEBUG:883
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(995);
// PUG_DEBUG:995
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(890);
// PUG_DEBUG:890
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'link'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(889);
// PUG_DEBUG:889
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(902);
// PUG_DEBUG:902
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__gallery-wrp'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(891);
// PUG_DEBUG:891
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(894);
// PUG_DEBUG:894
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'deal_type'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(893);
// PUG_DEBUG:893
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__label'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(892);
// PUG_DEBUG:892
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'deal_type')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(895);
// PUG_DEBUG:895
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(900);
// PUG_DEBUG:900
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'id'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(899);
// PUG_DEBUG:899
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__id'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(896);
// PUG_DEBUG:896
 ?>ID: <?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(897);
// PUG_DEBUG:897
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'id')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(898);
// PUG_DEBUG:898
 ?>

</div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(901);
// PUG_DEBUG:901
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(994);
// PUG_DEBUG:994
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(985);
// PUG_DEBUG:985
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(904);
// PUG_DEBUG:904
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(903);
// PUG_DEBUG:903
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(907);
// PUG_DEBUG:907
 ?><button<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__favorite'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'isFav') ? 'card-small__favorite--added' : ''))], ['@click' => 'toggleFav()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(906);
// PUG_DEBUG:906
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(905);
// PUG_DEBUG:905
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/like.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/like.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></button><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(910);
// PUG_DEBUG:910
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'name'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(909);
// PUG_DEBUG:909
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__text'], ['class' => 'card-small__text--gray'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(908);
// PUG_DEBUG:908
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'name')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(911);
// PUG_DEBUG:911
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(914);
// PUG_DEBUG:914
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'address'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(913);
// PUG_DEBUG:913
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__text'], ['class' => 'card-small__text--gray'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(912);
// PUG_DEBUG:912
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'address')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(915);
// PUG_DEBUG:915
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(983);
// PUG_DEBUG:983
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'specs'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(982);
// PUG_DEBUG:982
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'card-small__specs--', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'card_type')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(981);
// PUG_DEBUG:981
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $card, 'info') as $spec => $text) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(980);
// PUG_DEBUG:980
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs-item'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', call_user_func($GLOBALS['__jpv_plus'], 'card-small__specs-item--', (isset($spec) ? $spec : null)))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(918);
// PUG_DEBUG:918
 ?><?php if ((isset($spec) ? $spec : null) === 'ring') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(917);
// PUG_DEBUG:917
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(916);
// PUG_DEBUG:916
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/ring.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/ring.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(921);
// PUG_DEBUG:921
 }  if ((isset($spec) ? $spec : null) === 'square') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(920);
// PUG_DEBUG:920
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(919);
// PUG_DEBUG:919
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/ruller.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/ruller.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(924);
// PUG_DEBUG:924
 }  if ((isset($spec) ? $spec : null) === 'date') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(923);
// PUG_DEBUG:923
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '14'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(922);
// PUG_DEBUG:922
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/calendar.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/calendar.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(927);
// PUG_DEBUG:927
 }  if ((isset($spec) ? $spec : null) === 'facing') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(926);
// PUG_DEBUG:926
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '14'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(925);
// PUG_DEBUG:925
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/facing.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/facing.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(930);
// PUG_DEBUG:930
 }  if ((isset($spec) ? $spec : null) === 'area') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(929);
// PUG_DEBUG:929
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '15'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(928);
// PUG_DEBUG:928
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/fences.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/fences.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(933);
// PUG_DEBUG:933
 }  if ((isset($spec) ? $spec : null) === 'rooms') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(932);
// PUG_DEBUG:932
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(931);
// PUG_DEBUG:931
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/room.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/room.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(936);
// PUG_DEBUG:936
 }  if ((isset($spec) ? $spec : null) === 'bedrooms') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(935);
// PUG_DEBUG:935
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(934);
// PUG_DEBUG:934
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/bed.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/bed.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(939);
// PUG_DEBUG:939
 }  if ((isset($spec) ? $spec : null) === 'floor') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(938);
// PUG_DEBUG:938
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '14'], ['width' => '14'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(937);
// PUG_DEBUG:937
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/apartment.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/apartment.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(942);
// PUG_DEBUG:942
 }  if ((isset($spec) ? $spec : null) === 'metro') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(941);
// PUG_DEBUG:941
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '18'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(940);
// PUG_DEBUG:940
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/bus.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/bus.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(945);
// PUG_DEBUG:945
 }  if ((isset($spec) ? $spec : null) === 'forest') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(944);
// PUG_DEBUG:944
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(943);
// PUG_DEBUG:943
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/trees.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/trees.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(948);
// PUG_DEBUG:948
 }  if ((isset($spec) ? $spec : null) === 'water') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(947);
// PUG_DEBUG:947
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(946);
// PUG_DEBUG:946
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/waves.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/waves.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(951);
// PUG_DEBUG:951
 }  if ((isset($spec) ? $spec : null) === 'parking') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(950);
// PUG_DEBUG:950
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(949);
// PUG_DEBUG:949
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/parking.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/parking.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(954);
// PUG_DEBUG:954
 }  if ((isset($spec) ? $spec : null) === 'distance') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(953);
// PUG_DEBUG:953
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '15'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(952);
// PUG_DEBUG:952
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/route.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/route.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(957);
// PUG_DEBUG:957
 }  if ((isset($spec) ? $spec : null) === 'gas') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(956);
// PUG_DEBUG:956
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '15'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(955);
// PUG_DEBUG:955
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/gas.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/gas.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(960);
// PUG_DEBUG:960
 }  if ((isset($spec) ? $spec : null) === 'cleaner') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(959);
// PUG_DEBUG:959
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '15'], ['width' => '17'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(958);
// PUG_DEBUG:958
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/septik.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/septik.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(963);
// PUG_DEBUG:963
 }  if ((isset($spec) ? $spec : null) === 'pump') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(962);
// PUG_DEBUG:962
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '16'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(961);
// PUG_DEBUG:961
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/pumpjack.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/pumpjack.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(966);
// PUG_DEBUG:966
 }  if ((isset($spec) ? $spec : null) === 'sewage') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(965);
// PUG_DEBUG:965
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '17'], ['width' => '16'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(964);
// PUG_DEBUG:964
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/kanaliz.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/kanaliz.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(969);
// PUG_DEBUG:969
 }  if ((isset($spec) ? $spec : null) === 'class') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(968);
// PUG_DEBUG:968
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['height' => '13'], ['width' => '13'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(967);
// PUG_DEBUG:967
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/class.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/class.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(977);
// PUG_DEBUG:977
 }  if ((isset($spec) ? $spec : null) === 'metro') { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(976);
// PUG_DEBUG:976
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs-item-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(971);
// PUG_DEBUG:971
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(970);
// PUG_DEBUG:970
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($text) ? $text : null), 'station')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(974);
// PUG_DEBUG:974
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($text) ? $text : null), 'walk'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(973);
// PUG_DEBUG:973
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(972);
// PUG_DEBUG:972
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_plus'], ', ', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($text) ? $text : null), 'walk'))) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(975);
// PUG_DEBUG:975
 ?><!----><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(979);
// PUG_DEBUG:979
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__specs-item-text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(978);
// PUG_DEBUG:978
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } ?></div><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(984);
// PUG_DEBUG:984
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(988);
// PUG_DEBUG:988
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'price'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(987);
// PUG_DEBUG:987
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__price'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(986);
// PUG_DEBUG:986
 ?><?= (is_bool($_pug_temp = (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'price', 'request') ? 'По запросу' : call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'price', 'total'))) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(989);
// PUG_DEBUG:989
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(992);
// PUG_DEBUG:992
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'allObjects'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(991);
// PUG_DEBUG:991
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'card-small__all-objects'], ['href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'allObjects', 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(990);
// PUG_DEBUG:990
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($card) ? $card : null), 'allObjects', 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(993);
// PUG_DEBUG:993
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home-offers'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1024);
// PUG_DEBUG:1024
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-offers'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1013);
// PUG_DEBUG:1013
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-offers__head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1010);
// PUG_DEBUG:1010
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1009);
// PUG_DEBUG:1009
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')], [false, 'home-offers__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1012);
// PUG_DEBUG:1012
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'sTitle')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1011);
// PUG_DEBUG:1011
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
$__pug_mixin_name = 'title-fifth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'sTitle')], [false, 'title-fifth--up home-offers__s-title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1016);
// PUG_DEBUG:1016
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'tabs')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1015);
// PUG_DEBUG:1015
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-offers__tabs-wrap'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1014);
// PUG_DEBUG:1014
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
$__pug_mixin_name = 'tabs';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@changeTab' => 'changeTab']), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'tabs')], [false, 'home-offers__tabs']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?></div><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1023);
// PUG_DEBUG:1023
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-offers__items-wrap'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1022);
// PUG_DEBUG:1022
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'itemsWrap') as $i => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1021);
// PUG_DEBUG:1021
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-offers__items'], ['v-if' => 'activeTab === item.name'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1020);
// PUG_DEBUG:1020
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-offers__items-cards'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1019);
// PUG_DEBUG:1019
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'cards')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1018);
// PUG_DEBUG:1018
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'cards') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1017);
// PUG_DEBUG:1017
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes']([':key' => 'el.id']), [[false, (isset($el) ? $el : null)], [false, 'home-offers__item']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?><?php } ?></div></div><?php } ?></div></div><?php
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1035);
// PUG_DEBUG:1035
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'type') === 'hidden')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1034);
// PUG_DEBUG:1034
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('type', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'type'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1044);
// PUG_DEBUG:1044
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'className'), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked') && (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'value') === 'fail') ? 'input--fail' : ''), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked') && (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'value') === 'success') ? 'input--success' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1038);
// PUG_DEBUG:1038
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input__icon'], ['class' => 'input__icon--fail'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1037);
// PUG_DEBUG:1037
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1036);
// PUG_DEBUG:1036
 ?>!</span></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1041);
// PUG_DEBUG:1041
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input__icon'], ['class' => 'input__icon--success'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1040);
// PUG_DEBUG:1040
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1039);
// PUG_DEBUG:1039
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/check.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/check.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1042);
// PUG_DEBUG:1042
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'input__item'], ['ref' => 'input'], ['type' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('type', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'type'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], [':value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['placeholder' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('placeholder', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'placeholder'))], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['maxlength' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('maxlength', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'lengthString') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked', 'lengthString', 'max') : ''))], ['@input' => 'inputDefault($event.target.value)'], ['@change' => 'change($event.target.value)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1043);
// PUG_DEBUG:1043
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1118);
// PUG_DEBUG:1118
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-request'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1101);
// PUG_DEBUG:1101
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'picture')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1100);
// PUG_DEBUG:1100
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1102);
// PUG_DEBUG:1102
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1117);
// PUG_DEBUG:1117
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-request__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1104);
// PUG_DEBUG:1104
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1103);
// PUG_DEBUG:1103
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1105);
// PUG_DEBUG:1105
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1115);
// PUG_DEBUG:1115
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1114);
// PUG_DEBUG:1114
 ?><form<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'banner-request__form'], ['action' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('action', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'url'))], ['@submit.prevent' => 'onSubmit'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1107);
// PUG_DEBUG:1107
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'form', 'inputs') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1106);
// PUG_DEBUG:1106
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1109);
// PUG_DEBUG:1109
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'btn')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1108);
// PUG_DEBUG:1108
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1110);
// PUG_DEBUG:1110
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1112);
// PUG_DEBUG:1112
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'form', 'checkbox')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1111);
// PUG_DEBUG:1111
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1113);
// PUG_DEBUG:1113
 ?><!----><?php } ?></form><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1116);
// PUG_DEBUG:1116
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home-features'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1173);
// PUG_DEBUG:1173
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1149);
// PUG_DEBUG:1149
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1141);
// PUG_DEBUG:1141
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__head-left'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1136);
// PUG_DEBUG:1136
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1135);
// PUG_DEBUG:1135
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')], [false, 'home-features__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1137);
// PUG_DEBUG:1137
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1139);
// PUG_DEBUG:1139
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'sTitle')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1138);
// PUG_DEBUG:1138
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
$__pug_mixin_name = 'title-fifth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'sTitle')], [false, 'title-fifth--up home-features__text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1140);
// PUG_DEBUG:1140
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1148);
// PUG_DEBUG:1148
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__arrows'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1144);
// PUG_DEBUG:1144
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__arrow'], ['class' => 'home-features__arrow--prev'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1143);
// PUG_DEBUG:1143
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1142);
// PUG_DEBUG:1142
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-left.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-left.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1147);
// PUG_DEBUG:1147
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__arrow'], ['class' => 'home-features__arrow--next'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1146);
// PUG_DEBUG:1146
 ?><svg><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1145);
// PUG_DEBUG:1145
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right2.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right2.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></a></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1172);
// PUG_DEBUG:1172
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__slider'], ['class' => 'swiper-container'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1171);
// PUG_DEBUG:1171
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'swiper-wrapper'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1170);
// PUG_DEBUG:1170
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'slider') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1169);
// PUG_DEBUG:1169
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__slide'], ['class' => 'swiper-slide'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1153);
// PUG_DEBUG:1153
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'number')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1152);
// PUG_DEBUG:1152
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__slide-number'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1151);
// PUG_DEBUG:1151
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1150);
// PUG_DEBUG:1150
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'number')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1154);
// PUG_DEBUG:1154
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1156);
// PUG_DEBUG:1156
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1155);
// PUG_DEBUG:1155
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
$__pug_mixin_name = 'title-fifth';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'title')], [false, 'title-fifth--up home-features__slide-title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1157);
// PUG_DEBUG:1157
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1159);
// PUG_DEBUG:1159
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1158);
// PUG_DEBUG:1158
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')], [false, 'home-features__slide-text']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1160);
// PUG_DEBUG:1160
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1163);
// PUG_DEBUG:1163
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'link')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1162);
// PUG_DEBUG:1162
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__slide-link'], ['href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'link', 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1161);
// PUG_DEBUG:1161
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'link', 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1164);
// PUG_DEBUG:1164
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1167);
// PUG_DEBUG:1167
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'popup')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1166);
// PUG_DEBUG:1166
 ?><button<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home-features__slide-link'], ['type' => 'button'], ['@click' => 'popupOpen(item.popup.type, item.popup.name)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1165);
// PUG_DEBUG:1165
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'popup', 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1168);
// PUG_DEBUG:1168
 ?><!----><?php } ?></div><?php } ?></div></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['clients'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'obj', null], [false, 'className', null], [false, 'itemClass', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1198);
// PUG_DEBUG:1198
 ?><?php $visibleClients = 5 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1199);
// PUG_DEBUG:1199
 ?><?php $loadedClients = array(  ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1215);
// PUG_DEBUG:1215
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'clients'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1214);
// PUG_DEBUG:1214
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'clients__content'], ['class' => 'main'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1201);
// PUG_DEBUG:1201
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1200);
// PUG_DEBUG:1200
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'title')], [false, 'clients__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1202);
// PUG_DEBUG:1202
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1210);
// PUG_DEBUG:1210
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'clients__items'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1205);
// PUG_DEBUG:1205
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'items') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1204);
// PUG_DEBUG:1204
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'clients__item'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($itemClass) ? $itemClass : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1203);
// PUG_DEBUG:1203
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'clients__item-img'], ['class' => 'lazyload'], ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'img', 'src'))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'img', 'alt'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1208);
// PUG_DEBUG:1208
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($loadedClients) ? $loadedClients : null), 'length') !== 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1207);
// PUG_DEBUG:1207
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'clients__item'], ['v-for' => 'client in loadedClients'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($itemClass) ? $itemClass : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1206);
// PUG_DEBUG:1206
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'clients__item-img'], [':src' => 'client.img.src'], [':alt' => 'client.img.alt'], ['v-if' => 'client.img'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1209);
// PUG_DEBUG:1209
 ?><!----><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1212);
// PUG_DEBUG:1212
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'moreClients') && call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($loadedClients) ? $loadedClients : null), 'length') === 0)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1211);
// PUG_DEBUG:1211
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\\Formatter\\Format\\BasicFormat::merge_attributes'](['@click' => 'loadClients']), [[false, 'button'], [false, 'Показать ещё'], [false, 'btn--border clients__btn']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1213);
// PUG_DEBUG:1213
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['presentation'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1278);
// PUG_DEBUG:1278
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'presentation'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1269);
// PUG_DEBUG:1269
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'picture'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1268);
// PUG_DEBUG:1268
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'picture')], [false, 'presentation__background'], [false, 'lazyload']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1270);
// PUG_DEBUG:1270
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1277);
// PUG_DEBUG:1277
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'presentation__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1272);
// PUG_DEBUG:1272
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1271);
// PUG_DEBUG:1271
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title')], [false, 'presentation__title']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1273);
// PUG_DEBUG:1273
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1275);
// PUG_DEBUG:1275
 }  if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'btn'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1274);
// PUG_DEBUG:1274
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

$__pug_mixins[$__pug_mixin_name](false, $pugModule['Phug\Formatter\Format\BasicFormat::merge_attributes'](['@click' => 'popupOpen()']), [[false, 'button'], [false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'btn', 'text')], [false, 'btn--transparent btn--white presentation__btn']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1276);
// PUG_DEBUG:1276
 ?><!----><?php } ?></div></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['seo-links-item'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'item', null], [false, 'className', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1283);
// PUG_DEBUG:1283
 ?><?php $activeBtn = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1319);
// PUG_DEBUG:1319
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1291);
// PUG_DEBUG:1291
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__head'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'titleBtn') ? '' : 'seo-links__head--none-btn'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1287);
// PUG_DEBUG:1287
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'titleBtn')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1286);
// PUG_DEBUG:1286
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__head-btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( 'seo-links__head-btn--open' => (isset($isOpen) ? $isOpen : null) ))], ['@click' => 'toggleItOpen()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1285);
// PUG_DEBUG:1285
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1284);
// PUG_DEBUG:1284
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'titleBtn')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span></a><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1290);
// PUG_DEBUG:1290
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'title')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1289);
// PUG_DEBUG:1289
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__head-title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1288);
// PUG_DEBUG:1288
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'title')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></div><?php } ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1318);
// PUG_DEBUG:1318
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

$__pug_mixins[$__pug_mixin_name](true, array(  ), [[false, '0.5']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1317);
// PUG_DEBUG:1317
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__item-content-wrap'], ['v-if' => 'isOpen'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1316);
// PUG_DEBUG:1316
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__item-content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1311);
// PUG_DEBUG:1311
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__content-wrap'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'items_4_6') ? 'seo-links__content-wrap--parts' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1310);
// PUG_DEBUG:1310
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__content'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1297);
// PUG_DEBUG:1297
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'items')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1296);
// PUG_DEBUG:1296
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1295);
// PUG_DEBUG:1295
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'items') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1294);
// PUG_DEBUG:1294
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list-item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1293);
// PUG_DEBUG:1293
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list-link'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1292);
// PUG_DEBUG:1292
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></a></li><?php } ?></ul><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1303);
// PUG_DEBUG:1303
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'items_4_6')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1302);
// PUG_DEBUG:1302
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list'], ['class' => 'seo-links__list--4-6'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1301);
// PUG_DEBUG:1301
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'items_4_6') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1300);
// PUG_DEBUG:1300
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list-item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1299);
// PUG_DEBUG:1299
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list-link'], ['href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1298);
// PUG_DEBUG:1298
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></a></li><?php } ?></ul><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1309);
// PUG_DEBUG:1309
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'items_2_6')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1308);
// PUG_DEBUG:1308
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list'], ['class' => 'seo-links__list--2-6'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1307);
// PUG_DEBUG:1307
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $item, 'items_2_6') as $el) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1306);
// PUG_DEBUG:1306
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list-item'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1305);
// PUG_DEBUG:1305
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__list-link'], ['href' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('href', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'url'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1304);
// PUG_DEBUG:1304
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($el) ? $el : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?></a></li><?php } ?></ul><?php } ?></div></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1314);
// PUG_DEBUG:1314
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'btnOpen') && (isset($activeBtn) ? $activeBtn : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1313);
// PUG_DEBUG:1313
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links__btn-open'], ['@click' => 'changeAccordion()'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1312);
// PUG_DEBUG:1312
 ?>{{ textBtn }}</a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1315);
// PUG_DEBUG:1315
 ?><!----><?php } ?></div></div><?php
}); ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['seo-links'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1323);
// PUG_DEBUG:1323
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'seo-links'], ['class' => 'main'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1322);
// PUG_DEBUG:1322
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $obj, 'items') as $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1321);
// PUG_DEBUG:1321
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
$__pug_mixin_name = 'seo-links-item';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($item) ? $item : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
}); ?><?php } ?></div><?php
}; ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['home'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1362);
// PUG_DEBUG:1362
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'home'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1325);
// PUG_DEBUG:1325
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
$__pug_mixin_name = 'banner-home';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'banner')], [false, '']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1327);
// PUG_DEBUG:1327
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'filter')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1326);
// PUG_DEBUG:1326
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
$__pug_mixin_name = 'filter-home';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'filter')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1328);
// PUG_DEBUG:1328
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1330);
// PUG_DEBUG:1330
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'types')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1329);
// PUG_DEBUG:1329
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
$__pug_mixin_name = 'home-types';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'types')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1331);
// PUG_DEBUG:1331
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1333);
// PUG_DEBUG:1333
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'how')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1332);
// PUG_DEBUG:1332
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
$__pug_mixin_name = 'home-how';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'how')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1334);
// PUG_DEBUG:1334
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1336);
// PUG_DEBUG:1336
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'experience')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1335);
// PUG_DEBUG:1335
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
$__pug_mixin_name = 'home-experience';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'experience')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1337);
// PUG_DEBUG:1337
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1339);
// PUG_DEBUG:1339
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'services')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1338);
// PUG_DEBUG:1338
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
$__pug_mixin_name = 'home-services';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'services')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1340);
// PUG_DEBUG:1340
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1342);
// PUG_DEBUG:1342
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'agency')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1341);
// PUG_DEBUG:1341
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
$__pug_mixin_name = 'home-agency';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'agency')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1343);
// PUG_DEBUG:1343
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1345);
// PUG_DEBUG:1345
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'offers')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1344);
// PUG_DEBUG:1344
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
$__pug_mixin_name = 'home-offers';
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1346);
// PUG_DEBUG:1346
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1348);
// PUG_DEBUG:1348
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'request')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1347);
// PUG_DEBUG:1347
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

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'request')], [false, 'main'], [false, '']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1349);
// PUG_DEBUG:1349
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1351);
// PUG_DEBUG:1351
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'features')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1350);
// PUG_DEBUG:1350
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
$__pug_mixin_name = 'home-features';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'features')]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1352);
// PUG_DEBUG:1352
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1354);
// PUG_DEBUG:1354
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'clients')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1353);
// PUG_DEBUG:1353
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
$__pug_mixin_name = 'clients';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'clients')], [false, 'home__clients'], [false, 'clients__item--main']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1355);
// PUG_DEBUG:1355
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1357);
// PUG_DEBUG:1357
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'presentation')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1356);
// PUG_DEBUG:1356
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
$__pug_mixin_name = 'presentation';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'presentation')], [false, 'main']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1358);
// PUG_DEBUG:1358
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1360);
// PUG_DEBUG:1360
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'seoLinks')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1359);
// PUG_DEBUG:1359
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
$__pug_mixin_name = 'seo-links';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'seoLinks')], [false, 'home__seo-links']], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1361);
// PUG_DEBUG:1361
 ?><!----><?php } ?></div><?php
}; ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1365);
// PUG_DEBUG:1365
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1363);
// PUG_DEBUG:1363
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(150);
// PUG_DEBUG:150
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(127);
// PUG_DEBUG:127
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(134);
// PUG_DEBUG:134
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(138);
// PUG_DEBUG:138
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(501);
// PUG_DEBUG:501
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(423);
// PUG_DEBUG:423
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(158);
// PUG_DEBUG:158
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(197);
// PUG_DEBUG:197
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(161);
// PUG_DEBUG:161
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(168);
// PUG_DEBUG:168
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(213);
// PUG_DEBUG:213
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(226);
// PUG_DEBUG:226
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(304);
// PUG_DEBUG:304
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(265);
// PUG_DEBUG:265
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(229);
// PUG_DEBUG:229
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-fade'])) {
    $__pug_save_9588806 = $__pug_mixins['animation-fade'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(228);
// PUG_DEBUG:228
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(227);
// PUG_DEBUG:227
 ?></transition><?php
}; ?><?php if (isset($__pug_save_9588806)) {
    $__pug_mixins['animation-fade'] = $__pug_save_9588806;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(236);
// PUG_DEBUG:236
 ?><?php if (isset($__pug_mixins, $__pug_mixins['checkbox'])) {
    $__pug_save_5563829 = $__pug_mixins['checkbox'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(235);
// PUG_DEBUG:235
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(230);
// PUG_DEBUG:230
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__input'], ['type' => 'checkbox'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked'))], ['v-model' => 'obj.checked'], ['@change' => '$emit(\'change\', obj.checked)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(231);
// PUG_DEBUG:231
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(234);
// PUG_DEBUG:234
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(232);
// PUG_DEBUG:232
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(233);
// PUG_DEBUG:233
 ?></span></label><?php
}; ?><?php if (isset($__pug_save_5563829)) {
    $__pug_mixins['checkbox'] = $__pug_save_5563829;
}
 ?><?php if (isset($__pug_mixins, $__pug_mixins['select'])) {
    $__pug_save_4587845 = $__pug_mixins['select'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(237);
// PUG_DEBUG:237
 ?><?php $selected = array( 'text' => '' ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(238);
// PUG_DEBUG:238
 ?><?php $isOpen = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(264);
// PUG_DEBUG:264
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), array( 'select--open' => (isset($isOpen) ? $isOpen : null) ), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple') ? 'select--multiple' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(247);
// PUG_DEBUG:247
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head'], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') : ''))], ['ref' => 'head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(241);
// PUG_DEBUG:241
 ?><?php if ((isset($title) ? $title : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(240);
// PUG_DEBUG:240
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__pre-title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(239);
// PUG_DEBUG:239
 ?><?= (is_bool($_pug_temp = (isset($title) ? $title : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(242);
// PUG_DEBUG:242
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(244);
// PUG_DEBUG:244
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(243);
// PUG_DEBUG:243
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($selected) ? $selected : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(246);
// PUG_DEBUG:246
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head-ico'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(245);
// PUG_DEBUG:245
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(263);
// PUG_DEBUG:263
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(261);
// PUG_DEBUG:261
 ?><?php if (((isset($isOpen) ? $isOpen : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(260);
// PUG_DEBUG:260
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__dropdown'], ['ref' => 'dropdown'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(254);
// PUG_DEBUG:254
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(253);
// PUG_DEBUG:253
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(252);
// PUG_DEBUG:252
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(251);
// PUG_DEBUG:251
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( array( 'select__li--active' => (function_exists('computedClass') ? computedClass((isset($item) ? $item : null)) : call_user_func((isset($computedClass) ? $computedClass : null), (isset($item) ? $item : null))) ), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled') ? 'select__li--disabled' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(249);
// PUG_DEBUG:249
 ?><?php if ((!call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(248);
// PUG_DEBUG:248
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(250);
// PUG_DEBUG:250
 ?><!----><?php } ?></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(259);
// PUG_DEBUG:259
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(258);
// PUG_DEBUG:258
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(257);
// PUG_DEBUG:257
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['@click' => 'change(item)'], [':class' => '{&quot;select__li--active&quot; : computedClass(item)}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(256);
// PUG_DEBUG:256
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(255);
// PUG_DEBUG:255
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(262);
// PUG_DEBUG:262
 ?><!----><?php } ?><?php
}); ?></div><?php
}; ?><?php if (isset($__pug_save_4587845)) {
    $__pug_mixins['select'] = $__pug_save_4587845;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(308);
// PUG_DEBUG:308
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(311);
// PUG_DEBUG:311
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(353);
// PUG_DEBUG:353
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(314);
// PUG_DEBUG:314
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-fade'])) {
    $__pug_save_6521316 = $__pug_mixins['animation-fade'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(313);
// PUG_DEBUG:313
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(312);
// PUG_DEBUG:312
 ?></transition><?php
}; ?><?php if (isset($__pug_save_6521316)) {
    $__pug_mixins['animation-fade'] = $__pug_save_6521316;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(462);
// PUG_DEBUG:462
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(426);
// PUG_DEBUG:426
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-fade'])) {
    $__pug_save_3878944 = $__pug_mixins['animation-fade'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(425);
// PUG_DEBUG:425
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(424);
// PUG_DEBUG:424
 ?></transition><?php
}; ?><?php if (isset($__pug_save_3878944)) {
    $__pug_mixins['animation-fade'] = $__pug_save_3878944;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(433);
// PUG_DEBUG:433
 ?><?php if (isset($__pug_mixins, $__pug_mixins['checkbox'])) {
    $__pug_save_1002624 = $__pug_mixins['checkbox'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(432);
// PUG_DEBUG:432
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(427);
// PUG_DEBUG:427
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__input'], ['type' => 'checkbox'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked'))], ['v-model' => 'obj.checked'], ['@change' => '$emit(\'change\', obj.checked)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(428);
// PUG_DEBUG:428
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(431);
// PUG_DEBUG:431
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(429);
// PUG_DEBUG:429
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(430);
// PUG_DEBUG:430
 ?></span></label><?php
}; ?><?php if (isset($__pug_save_1002624)) {
    $__pug_mixins['checkbox'] = $__pug_save_1002624;
}
 ?><?php if (isset($__pug_mixins, $__pug_mixins['select'])) {
    $__pug_save_6463654 = $__pug_mixins['select'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(434);
// PUG_DEBUG:434
 ?><?php $selected = array( 'text' => '' ) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(435);
// PUG_DEBUG:435
 ?><?php $isOpen = false ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(461);
// PUG_DEBUG:461
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( (isset($className) ? $className : null), array( 'select--open' => (isset($isOpen) ? $isOpen : null) ), call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple') ? 'select--multiple' : '' ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(444);
// PUG_DEBUG:444
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head'], ['data-title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-title', (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') ? call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'title') : ''))], ['ref' => 'head'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(438);
// PUG_DEBUG:438
 ?><?php if ((isset($title) ? $title : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(437);
// PUG_DEBUG:437
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__pre-title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(436);
// PUG_DEBUG:436
 ?><?= (is_bool($_pug_temp = (isset($title) ? $title : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(439);
// PUG_DEBUG:439
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(441);
// PUG_DEBUG:441
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__title'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(440);
// PUG_DEBUG:440
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($selected) ? $selected : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(443);
// PUG_DEBUG:443
 ?><svg<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__head-ico'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(442);
// PUG_DEBUG:442
 ?><use<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['xlink:href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('xlink:href', (function_exists('loadAssets') ? loadAssets('./svg/arrow-right.svg') : call_user_func((isset($loadAssets) ? $loadAssets : null), './svg/arrow-right.svg')))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></use></svg></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(460);
// PUG_DEBUG:460
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(458);
// PUG_DEBUG:458
 ?><?php if (((isset($isOpen) ? $isOpen : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(457);
// PUG_DEBUG:457
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__dropdown'], ['ref' => 'dropdown'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(451);
// PUG_DEBUG:451
 ?><?php if ((call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($info) ? $info : null), 'multiple'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(450);
// PUG_DEBUG:450
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(449);
// PUG_DEBUG:449
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(448);
// PUG_DEBUG:448
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', array( array( 'select__li--active' => (function_exists('computedClass') ? computedClass((isset($item) ? $item : null)) : call_user_func((isset($computedClass) ? $computedClass : null), (isset($item) ? $item : null))) ), (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled') ? 'select__li--disabled' : '') ))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(446);
// PUG_DEBUG:446
 ?><?php if ((!call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'disabled'))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(445);
// PUG_DEBUG:445
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
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(447);
// PUG_DEBUG:447
 ?><!----><?php } ?></li><?php } ?></ul><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(456);
// PUG_DEBUG:456
 ?><ul<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__ul'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(455);
// PUG_DEBUG:455
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $info, 'values') as $index => $item) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(454);
// PUG_DEBUG:454
 ?><li<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'select__li'], ['@click' => 'change(item)'], [':class' => '{&quot;select__li--active&quot; : computedClass(item)}'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(453);
// PUG_DEBUG:453
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(452);
// PUG_DEBUG:452
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($item) ? $item : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?></span></li><?php } ?></ul><?php } ?></div><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(459);
// PUG_DEBUG:459
 ?><!----><?php } ?><?php
}); ?></div><?php
}; ?><?php if (isset($__pug_save_6463654)) {
    $__pug_mixins['select'] = $__pug_save_6463654;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(540);
// PUG_DEBUG:540
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(508);
// PUG_DEBUG:508
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(512);
// PUG_DEBUG:512
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(624);
// PUG_DEBUG:624
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(544);
// PUG_DEBUG:544
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(548);
// PUG_DEBUG:548
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_7688910 = $__pug_mixins['text'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(547);
// PUG_DEBUG:547
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(545);
// PUG_DEBUG:545
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(546);
// PUG_DEBUG:546
 ?></p><?php
}; ?><?php if (isset($__pug_save_7688910)) {
    $__pug_mixins['text'] = $__pug_save_7688910;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(579);
// PUG_DEBUG:579
 ?><?php if (isset($__pug_mixins, $__pug_mixins['picture'])) {
    $__pug_save_8619687 = $__pug_mixins['picture'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(563);
// PUG_DEBUG:563
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(562);
// PUG_DEBUG:562
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(551);
// PUG_DEBUG:551
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(550);
// PUG_DEBUG:550
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(549);
// PUG_DEBUG:549
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(552);
// PUG_DEBUG:552
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(555);
// PUG_DEBUG:555
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(554);
// PUG_DEBUG:554
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(553);
// PUG_DEBUG:553
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(556);
// PUG_DEBUG:556
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(559);
// PUG_DEBUG:559
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(558);
// PUG_DEBUG:558
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(557);
// PUG_DEBUG:557
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(560);
// PUG_DEBUG:560
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(561);
// PUG_DEBUG:561
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(578);
// PUG_DEBUG:578
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(566);
// PUG_DEBUG:566
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(565);
// PUG_DEBUG:565
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(564);
// PUG_DEBUG:564
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(567);
// PUG_DEBUG:567
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(570);
// PUG_DEBUG:570
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(569);
// PUG_DEBUG:569
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(568);
// PUG_DEBUG:568
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(571);
// PUG_DEBUG:571
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(574);
// PUG_DEBUG:574
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(573);
// PUG_DEBUG:573
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(572);
// PUG_DEBUG:572
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(575);
// PUG_DEBUG:575
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(576);
// PUG_DEBUG:576
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(577);
// PUG_DEBUG:577
 ?></picture><?php } ?><?php
}; ?><?php if (isset($__pug_save_8619687)) {
    $__pug_mixins['picture'] = $__pug_save_8619687;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(700);
// PUG_DEBUG:700
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(628);
// PUG_DEBUG:628
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(635);
// PUG_DEBUG:635
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_6924934 = $__pug_mixins['title'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(631);
// PUG_DEBUG:631
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(630);
// PUG_DEBUG:630
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(629);
// PUG_DEBUG:629
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(634);
// PUG_DEBUG:634
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(632);
// PUG_DEBUG:632
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(633);
// PUG_DEBUG:633
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_6924934)) {
    $__pug_mixins['title'] = $__pug_save_6924934;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(639);
// PUG_DEBUG:639
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_1790575 = $__pug_mixins['text'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(638);
// PUG_DEBUG:638
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(636);
// PUG_DEBUG:636
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(637);
// PUG_DEBUG:637
 ?></p><?php
}; ?><?php if (isset($__pug_save_1790575)) {
    $__pug_mixins['text'] = $__pug_save_1790575;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(655);
// PUG_DEBUG:655
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_6919110 = $__pug_mixins['btn'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(644);
// PUG_DEBUG:644
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(643);
// PUG_DEBUG:643
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(640);
// PUG_DEBUG:640
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(642);
// PUG_DEBUG:642
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(641);
// PUG_DEBUG:641
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(649);
// PUG_DEBUG:649
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(648);
// PUG_DEBUG:648
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(645);
// PUG_DEBUG:645
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(647);
// PUG_DEBUG:647
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(646);
// PUG_DEBUG:646
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(654);
// PUG_DEBUG:654
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(650);
// PUG_DEBUG:650
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(652);
// PUG_DEBUG:652
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(651);
// PUG_DEBUG:651
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(653);
// PUG_DEBUG:653
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_6919110)) {
    $__pug_mixins['btn'] = $__pug_save_6919110;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(686);
// PUG_DEBUG:686
 ?><?php if (isset($__pug_mixins, $__pug_mixins['picture'])) {
    $__pug_save_3693266 = $__pug_mixins['picture'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(670);
// PUG_DEBUG:670
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(669);
// PUG_DEBUG:669
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(658);
// PUG_DEBUG:658
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(657);
// PUG_DEBUG:657
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(656);
// PUG_DEBUG:656
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(659);
// PUG_DEBUG:659
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(662);
// PUG_DEBUG:662
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(661);
// PUG_DEBUG:661
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(660);
// PUG_DEBUG:660
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(663);
// PUG_DEBUG:663
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(666);
// PUG_DEBUG:666
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(665);
// PUG_DEBUG:665
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(664);
// PUG_DEBUG:664
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(667);
// PUG_DEBUG:667
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(668);
// PUG_DEBUG:668
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(685);
// PUG_DEBUG:685
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(673);
// PUG_DEBUG:673
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(672);
// PUG_DEBUG:672
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(671);
// PUG_DEBUG:671
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(674);
// PUG_DEBUG:674
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(677);
// PUG_DEBUG:677
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(676);
// PUG_DEBUG:676
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(675);
// PUG_DEBUG:675
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(678);
// PUG_DEBUG:678
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(681);
// PUG_DEBUG:681
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(680);
// PUG_DEBUG:680
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(679);
// PUG_DEBUG:679
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(682);
// PUG_DEBUG:682
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(683);
// PUG_DEBUG:683
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(684);
// PUG_DEBUG:684
 ?></picture><?php } ?><?php
}; ?><?php if (isset($__pug_save_3693266)) {
    $__pug_mixins['picture'] = $__pug_save_3693266;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(778);
// PUG_DEBUG:778
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(707);
// PUG_DEBUG:707
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_2564994 = $__pug_mixins['title'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(703);
// PUG_DEBUG:703
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(702);
// PUG_DEBUG:702
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(701);
// PUG_DEBUG:701
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(706);
// PUG_DEBUG:706
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(704);
// PUG_DEBUG:704
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(705);
// PUG_DEBUG:705
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_2564994)) {
    $__pug_mixins['title'] = $__pug_save_2564994;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(714);
// PUG_DEBUG:714
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title-fourth'])) {
    $__pug_save_9652710 = $__pug_mixins['title-fourth'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-fourth'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'text', null], [false, 'className', null], [false, 'isH1', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(710);
// PUG_DEBUG:710
 ?><?php if ((isset($isH1) ? $isH1 : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(709);
// PUG_DEBUG:709
 ?><h1<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fourth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(708);
// PUG_DEBUG:708
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></h1><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(713);
// PUG_DEBUG:713
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fourth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(711);
// PUG_DEBUG:711
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(712);
// PUG_DEBUG:712
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_9652710)) {
    $__pug_mixins['title-fourth'] = $__pug_save_9652710;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(718);
// PUG_DEBUG:718
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_6961778 = $__pug_mixins['text'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(717);
// PUG_DEBUG:717
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(715);
// PUG_DEBUG:715
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(716);
// PUG_DEBUG:716
 ?></p><?php
}; ?><?php if (isset($__pug_save_6961778)) {
    $__pug_mixins['text'] = $__pug_save_6961778;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(741);
// PUG_DEBUG:741
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(725);
// PUG_DEBUG:725
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title-fourth'])) {
    $__pug_save_1348235 = $__pug_mixins['title-fourth'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-fourth'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'text', null], [false, 'className', null], [false, 'isH1', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(721);
// PUG_DEBUG:721
 ?><?php if ((isset($isH1) ? $isH1 : null)) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(720);
// PUG_DEBUG:720
 ?><h1<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fourth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(719);
// PUG_DEBUG:719
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></h1><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(724);
// PUG_DEBUG:724
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fourth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(722);
// PUG_DEBUG:722
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(723);
// PUG_DEBUG:723
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_1348235)) {
    $__pug_mixins['title-fourth'] = $__pug_save_1348235;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(729);
// PUG_DEBUG:729
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_8850778 = $__pug_mixins['text'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(728);
// PUG_DEBUG:728
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(726);
// PUG_DEBUG:726
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(727);
// PUG_DEBUG:727
 ?></p><?php
}; ?><?php if (isset($__pug_save_8850778)) {
    $__pug_mixins['text'] = $__pug_save_8850778;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(753);
// PUG_DEBUG:753
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(852);
// PUG_DEBUG:852
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(782);
// PUG_DEBUG:782
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title-fifth'])) {
    $__pug_save_4342166 = $__pug_mixins['title-fifth'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-fifth'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(781);
// PUG_DEBUG:781
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fifth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(779);
// PUG_DEBUG:779
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(780);
// PUG_DEBUG:780
 ?></div><?php
}; ?><?php if (isset($__pug_save_4342166)) {
    $__pug_mixins['title-fifth'] = $__pug_save_4342166;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(786);
// PUG_DEBUG:786
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_5684073 = $__pug_mixins['text'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(785);
// PUG_DEBUG:785
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(783);
// PUG_DEBUG:783
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(784);
// PUG_DEBUG:784
 ?></p><?php
}; ?><?php if (isset($__pug_save_5684073)) {
    $__pug_mixins['text'] = $__pug_save_5684073;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(817);
// PUG_DEBUG:817
 ?><?php if (isset($__pug_mixins, $__pug_mixins['picture'])) {
    $__pug_save_8718576 = $__pug_mixins['picture'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(801);
// PUG_DEBUG:801
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(800);
// PUG_DEBUG:800
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(789);
// PUG_DEBUG:789
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(788);
// PUG_DEBUG:788
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(787);
// PUG_DEBUG:787
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(790);
// PUG_DEBUG:790
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(793);
// PUG_DEBUG:793
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(792);
// PUG_DEBUG:792
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(791);
// PUG_DEBUG:791
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(794);
// PUG_DEBUG:794
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(797);
// PUG_DEBUG:797
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(796);
// PUG_DEBUG:796
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(795);
// PUG_DEBUG:795
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(798);
// PUG_DEBUG:798
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(799);
// PUG_DEBUG:799
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(816);
// PUG_DEBUG:816
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(804);
// PUG_DEBUG:804
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(803);
// PUG_DEBUG:803
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(802);
// PUG_DEBUG:802
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(805);
// PUG_DEBUG:805
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(808);
// PUG_DEBUG:808
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(807);
// PUG_DEBUG:807
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(806);
// PUG_DEBUG:806
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(809);
// PUG_DEBUG:809
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(812);
// PUG_DEBUG:812
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(811);
// PUG_DEBUG:811
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(810);
// PUG_DEBUG:810
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(813);
// PUG_DEBUG:813
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(814);
// PUG_DEBUG:814
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(815);
// PUG_DEBUG:815
 ?></picture><?php } ?><?php
}; ?><?php if (isset($__pug_save_8718576)) {
    $__pug_mixins['picture'] = $__pug_save_8718576;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1025);
// PUG_DEBUG:1025
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(859);
// PUG_DEBUG:859
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_8597939 = $__pug_mixins['title'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(855);
// PUG_DEBUG:855
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(854);
// PUG_DEBUG:854
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(853);
// PUG_DEBUG:853
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(858);
// PUG_DEBUG:858
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(856);
// PUG_DEBUG:856
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(857);
// PUG_DEBUG:857
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_8597939)) {
    $__pug_mixins['title'] = $__pug_save_8597939;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(863);
// PUG_DEBUG:863
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(867);
// PUG_DEBUG:867
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title-fifth'])) {
    $__pug_save_6126198 = $__pug_mixins['title-fifth'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-fifth'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(866);
// PUG_DEBUG:866
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fifth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(864);
// PUG_DEBUG:864
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(865);
// PUG_DEBUG:865
 ?></div><?php
}; ?><?php if (isset($__pug_save_6126198)) {
    $__pug_mixins['title-fifth'] = $__pug_save_6126198;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(871);
// PUG_DEBUG:871
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(996);
// PUG_DEBUG:996
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(888);
// PUG_DEBUG:888
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1008);
// PUG_DEBUG:1008
 ?><?php if (isset($__pug_mixins, $__pug_mixins['tabs'])) {
    $__pug_save_7282526 = $__pug_mixins['tabs'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['tabs'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    $__pug_attributes = [[false, 'btns', null], [false, 'className', null]];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1007);
// PUG_DEBUG:1007
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tabs'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1006);
// PUG_DEBUG:1006
 ?><?php foreach ($btns as $btn) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1005);
// PUG_DEBUG:1005
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'tabs__btn'], ['@click' => 'switchBtn(btn.value)'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', ((isset($activeBtn) ? $activeBtn : null) === call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'value') ? 'tabs__btn--active' : ''))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(997);
// PUG_DEBUG:997
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(998);
// PUG_DEBUG:998
 ?><?= htmlspecialchars((is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp)) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(999);
// PUG_DEBUG:999
 ?>

<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1002);
// PUG_DEBUG:1002
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1001);
// PUG_DEBUG:1001
 ?><span><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1000);
// PUG_DEBUG:1000
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_plus'], ' ', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($btn) ? $btn : null), 'count'))) ? var_export($_pug_temp, true) : $_pug_temp) ?></span><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1003);
// PUG_DEBUG:1003
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1004);
// PUG_DEBUG:1004
 ?></div><?php } ?></div><?php
}; ?><?php if (isset($__pug_save_7282526)) {
    $__pug_mixins['tabs'] = $__pug_save_7282526;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1119);
// PUG_DEBUG:1119
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1029);
// PUG_DEBUG:1029
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title-second'])) {
    $__pug_save_560593 = $__pug_mixins['title-second'];
}
 ?><?php if (!isset($__pug_mixins)) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1028);
// PUG_DEBUG:1028
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-second'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1026);
// PUG_DEBUG:1026
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1027);
// PUG_DEBUG:1027
 ?></div><?php
}; ?><?php if (isset($__pug_save_560593)) {
    $__pug_mixins['title-second'] = $__pug_save_560593;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1033);
// PUG_DEBUG:1033
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_200377 = $__pug_mixins['text'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1032);
// PUG_DEBUG:1032
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1030);
// PUG_DEBUG:1030
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1031);
// PUG_DEBUG:1031
 ?></p><?php
}; ?><?php if (isset($__pug_save_200377)) {
    $__pug_mixins['text'] = $__pug_save_200377;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1045);
// PUG_DEBUG:1045
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1061);
// PUG_DEBUG:1061
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_77772 = $__pug_mixins['btn'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1050);
// PUG_DEBUG:1050
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1049);
// PUG_DEBUG:1049
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1046);
// PUG_DEBUG:1046
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1048);
// PUG_DEBUG:1048
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1047);
// PUG_DEBUG:1047
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1055);
// PUG_DEBUG:1055
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1054);
// PUG_DEBUG:1054
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1051);
// PUG_DEBUG:1051
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1053);
// PUG_DEBUG:1053
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1052);
// PUG_DEBUG:1052
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1060);
// PUG_DEBUG:1060
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1056);
// PUG_DEBUG:1056
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1058);
// PUG_DEBUG:1058
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1057);
// PUG_DEBUG:1057
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1059);
// PUG_DEBUG:1059
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_77772)) {
    $__pug_mixins['btn'] = $__pug_save_77772;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1068);
// PUG_DEBUG:1068
 ?><?php if (isset($__pug_mixins, $__pug_mixins['checkbox'])) {
    $__pug_save_8817893 = $__pug_mixins['checkbox'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1067);
// PUG_DEBUG:1067
 ?><label<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1062);
// PUG_DEBUG:1062
 ?><input<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__input'], ['type' => 'checkbox'], ['name' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('name', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'name'))], ['value' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('value', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'value'))], ['checked' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('checked', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'checked'))], ['v-model' => 'obj.checked'], ['@change' => '$emit(\'change\', obj.checked)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1063);
// PUG_DEBUG:1063
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__icon'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1066);
// PUG_DEBUG:1066
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'checkbox__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1064);
// PUG_DEBUG:1064
 ?><?= (is_bool($_pug_temp = call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($obj) ? $obj : null), 'text')) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1065);
// PUG_DEBUG:1065
 ?></span></label><?php
}; ?><?php if (isset($__pug_save_8817893)) {
    $__pug_mixins['checkbox'] = $__pug_save_8817893;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1099);
// PUG_DEBUG:1099
 ?><?php if (isset($__pug_mixins, $__pug_mixins['picture'])) {
    $__pug_save_8725623 = $__pug_mixins['picture'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1083);
// PUG_DEBUG:1083
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1082);
// PUG_DEBUG:1082
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1071);
// PUG_DEBUG:1071
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1070);
// PUG_DEBUG:1070
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1069);
// PUG_DEBUG:1069
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1072);
// PUG_DEBUG:1072
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1075);
// PUG_DEBUG:1075
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1074);
// PUG_DEBUG:1074
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1073);
// PUG_DEBUG:1073
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1076);
// PUG_DEBUG:1076
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1079);
// PUG_DEBUG:1079
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1078);
// PUG_DEBUG:1078
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1077);
// PUG_DEBUG:1077
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1080);
// PUG_DEBUG:1080
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1081);
// PUG_DEBUG:1081
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1098);
// PUG_DEBUG:1098
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1086);
// PUG_DEBUG:1086
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1085);
// PUG_DEBUG:1085
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1084);
// PUG_DEBUG:1084
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1087);
// PUG_DEBUG:1087
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1090);
// PUG_DEBUG:1090
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1089);
// PUG_DEBUG:1089
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1088);
// PUG_DEBUG:1088
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1091);
// PUG_DEBUG:1091
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1094);
// PUG_DEBUG:1094
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1093);
// PUG_DEBUG:1093
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1092);
// PUG_DEBUG:1092
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1095);
// PUG_DEBUG:1095
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1096);
// PUG_DEBUG:1096
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1097);
// PUG_DEBUG:1097
 ?></picture><?php } ?><?php
}; ?><?php if (isset($__pug_save_8725623)) {
    $__pug_mixins['picture'] = $__pug_save_8725623;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1174);
// PUG_DEBUG:1174
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1126);
// PUG_DEBUG:1126
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_3058678 = $__pug_mixins['title'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1122);
// PUG_DEBUG:1122
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1121);
// PUG_DEBUG:1121
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1120);
// PUG_DEBUG:1120
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1125);
// PUG_DEBUG:1125
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1123);
// PUG_DEBUG:1123
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1124);
// PUG_DEBUG:1124
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_3058678)) {
    $__pug_mixins['title'] = $__pug_save_3058678;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1130);
// PUG_DEBUG:1130
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title-fifth'])) {
    $__pug_save_2638260 = $__pug_mixins['title-fifth'];
}
 ?><?php if (!isset($__pug_mixins)) {
    $__pug_mixins = [];
}
$__pug_mixins['title-fifth'] = function ($block, $attributes, $__pug_arguments, $__pug_mixin_vars, $__pug_children) use (&$__pug_mixins, &$pugModule) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1129);
// PUG_DEBUG:1129
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-fifth'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1127);
// PUG_DEBUG:1127
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1128);
// PUG_DEBUG:1128
 ?></div><?php
}; ?><?php if (isset($__pug_save_2638260)) {
    $__pug_mixins['title-fifth'] = $__pug_save_2638260;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1134);
// PUG_DEBUG:1134
 ?><?php if (isset($__pug_mixins, $__pug_mixins['text'])) {
    $__pug_save_7534980 = $__pug_mixins['text'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1133);
// PUG_DEBUG:1133
 ?><p<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'text'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1131);
// PUG_DEBUG:1131
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1132);
// PUG_DEBUG:1132
 ?></p><?php
}; ?><?php if (isset($__pug_save_7534980)) {
    $__pug_mixins['text'] = $__pug_save_7534980;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1216);
// PUG_DEBUG:1216
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1181);
// PUG_DEBUG:1181
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title'])) {
    $__pug_save_3060854 = $__pug_mixins['title'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1177);
// PUG_DEBUG:1177
 ?><?php if (((isset($link) ? $link : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1176);
// PUG_DEBUG:1176
 ?><a<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($link) ? $link : null))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', (isset($title) ? $title : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1175);
// PUG_DEBUG:1175
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?></a><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1180);
// PUG_DEBUG:1180
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1178);
// PUG_DEBUG:1178
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1179);
// PUG_DEBUG:1179
 ?></div><?php } ?><?php
}; ?><?php if (isset($__pug_save_3060854)) {
    $__pug_mixins['title'] = $__pug_save_3060854;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1197);
// PUG_DEBUG:1197
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_3381740 = $__pug_mixins['btn'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1186);
// PUG_DEBUG:1186
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1185);
// PUG_DEBUG:1185
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1182);
// PUG_DEBUG:1182
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1184);
// PUG_DEBUG:1184
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1183);
// PUG_DEBUG:1183
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1191);
// PUG_DEBUG:1191
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1190);
// PUG_DEBUG:1190
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1187);
// PUG_DEBUG:1187
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1189);
// PUG_DEBUG:1189
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1188);
// PUG_DEBUG:1188
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1196);
// PUG_DEBUG:1196
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1192);
// PUG_DEBUG:1192
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1194);
// PUG_DEBUG:1194
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1193);
// PUG_DEBUG:1193
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1195);
// PUG_DEBUG:1195
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_3381740)) {
    $__pug_mixins['btn'] = $__pug_save_3381740;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1279);
// PUG_DEBUG:1279
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1220);
// PUG_DEBUG:1220
 ?><?php if (isset($__pug_mixins, $__pug_mixins['title-second'])) {
    $__pug_save_1864741 = $__pug_mixins['title-second'];
}
 ?><?php if (!isset($__pug_mixins)) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1219);
// PUG_DEBUG:1219
 ?><div<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'title-second'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1217);
// PUG_DEBUG:1217
 ?><?= (is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1218);
// PUG_DEBUG:1218
 ?></div><?php
}; ?><?php if (isset($__pug_save_1864741)) {
    $__pug_mixins['title-second'] = $__pug_save_1864741;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1236);
// PUG_DEBUG:1236
 ?><?php if (isset($__pug_mixins, $__pug_mixins['btn'])) {
    $__pug_save_4606300 = $__pug_mixins['btn'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1225);
// PUG_DEBUG:1225
 ?><?php if (((isset($tag) ? $tag : null) === 'div')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1224);
// PUG_DEBUG:1224
 ?><div<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1221);
// PUG_DEBUG:1221
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1223);
// PUG_DEBUG:1223
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1222);
// PUG_DEBUG:1222
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></div><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1230);
// PUG_DEBUG:1230
 }  elseif(((isset($tag) ? $tag : null) === 'button')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1229);
// PUG_DEBUG:1229
 ?><button<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1226);
// PUG_DEBUG:1226
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['class' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('class', (isset($className) ? $className : null))], ['@click' => '$emit(\'click\')'], [':disabled' => 'disabled'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1228);
// PUG_DEBUG:1228
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1227);
// PUG_DEBUG:1227
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?></button><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1235);
// PUG_DEBUG:1235
 ?><a<?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1231);
// PUG_DEBUG:1231
 ?><?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment']($attributes, ['class' => 'btn'], ['href' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('href', (isset($tag) ? $tag : null))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1233);
// PUG_DEBUG:1233
 ?><span<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'btn__text'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1232);
// PUG_DEBUG:1232
 ?><?= htmlspecialchars((is_bool($_pug_temp = (isset($text) ? $text : null)) ? var_export($_pug_temp, true) : $_pug_temp)) ?></span><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1234);
// PUG_DEBUG:1234
 ?></a><?php } ?><?php
}; ?><?php if (isset($__pug_save_4606300)) {
    $__pug_mixins['btn'] = $__pug_save_4606300;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1267);
// PUG_DEBUG:1267
 ?><?php if (isset($__pug_mixins, $__pug_mixins['picture'])) {
    $__pug_save_7606279 = $__pug_mixins['picture'];
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1251);
// PUG_DEBUG:1251
 ?><?php if (((isset($optimize) ? $optimize : null))) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1250);
// PUG_DEBUG:1250
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1239);
// PUG_DEBUG:1239
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1238);
// PUG_DEBUG:1238
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1237);
// PUG_DEBUG:1237
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1240);
// PUG_DEBUG:1240
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1243);
// PUG_DEBUG:1243
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1242);
// PUG_DEBUG:1242
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1241);
// PUG_DEBUG:1241
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1244);
// PUG_DEBUG:1244
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1247);
// PUG_DEBUG:1247
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1246);
// PUG_DEBUG:1246
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1245);
// PUG_DEBUG:1245
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['data-srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('data-srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1248);
// PUG_DEBUG:1248
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1249);
// PUG_DEBUG:1249
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['data-src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('data-src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($optimize) ? $optimize : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /></picture><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1266);
// PUG_DEBUG:1266
 ?><picture<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['class' => 'picture'], ['class' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('class', (isset($className) ? $className : null))])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1254);
// PUG_DEBUG:1254
 ?><?php if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'mobile')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1253);
// PUG_DEBUG:1253
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'mobile') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1252);
// PUG_DEBUG:1252
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(max-width: 767px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1255);
// PUG_DEBUG:1255
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1258);
// PUG_DEBUG:1258
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'tablet')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1257);
// PUG_DEBUG:1257
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'tablet') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1256);
// PUG_DEBUG:1256
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 768px) and (max-width: 1279px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1259);
// PUG_DEBUG:1259
 ?><!----><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1262);
// PUG_DEBUG:1262
 }  if (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop')) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1261);
// PUG_DEBUG:1261
 ?><?php foreach (call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], $data, 'sources', 'desktop') as $image) { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1260);
// PUG_DEBUG:1260
 ?><source<?= (is_bool($_pug_temp = $pugModule['Phug\Formatter\Format\BasicFormat::attributes_assignment'](array(  ), ['srcset' => $pugModule['Phug\Formatter\Format\BasicFormat::array_escape']('srcset', (isset($image) ? $image : null))], ['media' => '(min-width: 1280px)'])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php } ?><?php } else { ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1263);
// PUG_DEBUG:1263
 ?><!----><?php } ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1264);
// PUG_DEBUG:1264
 ?><img<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), ['src' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('src', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'sources', 'desktop', 0))], ['alt' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('alt', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'alt'))], ['title' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape']('title', call_user_func($GLOBALS['__jpv_dotWithArrayPrototype'], (isset($data) ? $data : null), 'title'))])) ? var_export($_pug_temp, true) : $_pug_temp) ?> /><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1265);
// PUG_DEBUG:1265
 ?></picture><?php } ?><?php
}; ?><?php if (isset($__pug_save_7606279)) {
    $__pug_mixins['picture'] = $__pug_save_7606279;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1324);
// PUG_DEBUG:1324
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1320);
// PUG_DEBUG:1320
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1282);
// PUG_DEBUG:1282
 ?><?php if (isset($__pug_mixins, $__pug_mixins['animation-height'])) {
    $__pug_save_6961869 = $__pug_mixins['animation-height'];
}
 ?><?php if (!isset($__pug_mixins)) {
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
    
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1281);
// PUG_DEBUG:1281
 ?><transition<?= (is_bool($_pug_temp = $pugModule['Phug\\Formatter\\Format\\BasicFormat::attributes_assignment'](array(  ), [':css' => 'false'], [':duration' => $pugModule['Phug\\Formatter\\Format\\BasicFormat::array_escape'](':duration', (isset($duration) ? $duration : null))], ['@before-enter' => 'beforeEnter'], ['@enter' => 'enter'], ['@leave' => 'leave'], ['@after-leave' => 'afterLeave'])) ? var_export($_pug_temp, true) : $_pug_temp) ?>><?= (is_bool($_pug_temp = $__pug_children(get_defined_vars())) ? var_export($_pug_temp, true) : $_pug_temp) ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1280);
// PUG_DEBUG:1280
 ?></transition><?php
}; ?><?php if (isset($__pug_save_6961869)) {
    $__pug_mixins['animation-height'] = $__pug_save_6961869;
}
 ?><?php 
\Phug\Renderer\Profiler\ProfilerModule::recordProfilerDisplayEvent(1364);
// PUG_DEBUG:1364
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
$__pug_mixin_name = 'home';
if (!isset($__pug_mixins[$__pug_mixin_name])) {
    throw new \InvalidArgumentException("Unknown $__pug_mixin_name mixin called.");
}

$__pug_mixins[$__pug_mixin_name](false, array(  ), [[false, (isset($indexPage) ? $indexPage : null)]], $__pug_mixin_vars, function ($__pug_children_vars) use (&$__pug_mixins, $__pug_children, $pug_vars, &$pugModule) {
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