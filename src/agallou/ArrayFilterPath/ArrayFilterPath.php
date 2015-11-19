<?php

namespace agallou\ArrayFilterPath;

class ArrayFilterPath
{

    public function filter(array $array, array $filters)
    {
        return $this->getFilteredArray($array, $filters);
    }

    protected function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    protected function getPath($key, $base, $parentAssoc)
    {
        $path = $base;
        if ($parentAssoc) {
            if (null !== $base) {
                $path .= '.';
            }
            $path .= $key;
        } else {
             $path .= "[]";
        }
        return $path;
    }


    protected function getFilteredArray($object, $filters, $base = null, $tree = array(), &$filtered = array())
    {
        $isAssoc = is_array($object) && $this->isAssoc($object);
        foreach ($object as $key => $value) {
            $path = $this->getPath($key, $base, $isAssoc);
            $treeCopy = $tree;
            $treeCopy[] = $key;
            if (is_array($value)) {
                $this->getFilteredArray($value, $filters, $path, $treeCopy, $filtered);
            } else {
                $isFiltered = false;
                foreach ($filters as $filter) {
                    $filter = str_replace('[]', preg_quote('[]'), $filter);
                    $pattern = '/' . $filter . '/';
                    if (preg_match($pattern, $path)) {
                        $isFiltered = true;
                        break;
                    }
                }
                if (!$isFiltered) {
                    continue;
                }
                $treeLeaf = &$filtered;
                foreach ($treeCopy as $treeKey) {
                    if (!isset($treeLeaf[$treeKey])) {
                        $treeLeaf[$treeKey] = array();
                    }
                    $treeLeaf = &$treeLeaf[$treeKey];
                }
                $treeLeaf = $value;
            }
        }
        return $filtered;
    }
}
