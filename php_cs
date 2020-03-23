<?php
/**
 * Config for PHP-CS-Fixer ver2
 */
 
$rules = [
    '@PSR2' => true,
    // addtional rules
    'array_indentation' => true,
    'array_syntax' => ['syntax' => 'short'],
    'no_multiline_whitespace_before_semicolons' => true,
    'no_short_echo_tag' => true,
    'no_unused_imports' => true,
    'not_operator_with_successor_space' => true,
    'method_chaining_indentation' => true,
    'align_multiline_comment' => true,
    'blank_line_before_statement' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_whitespace' => true,
    'no_unneeded_control_parentheses' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
    'no_whitespace_in_blank_line' => true,
    'no_whitespace_before_comma_in_array' => true,
    'normalize_index_brace' => true,
    'trailing_comma_in_multiline_array' => true,
    'binary_operator_spaces' => ['default' => 'align'],
];
$excludes = [
    // add exclude project directory
    'vendor',
    'node_modules',
];
return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude($excludes)
            ->notName('README.md')
            ->notName('*.xml')
            ->notName('*.yml')
    );