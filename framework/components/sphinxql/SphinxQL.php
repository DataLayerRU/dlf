<?php

namespace pwf\components\sphinxql;

class SphinxQL extends \Foolz\SphinxQL\SphinxQL implements \pwf\components\datapaginator\interfaces\Paginatable
{

    /**
     * Count results
     *
     * @return int
     */
    public function count()
    {
        $self         = clone $this;
        $self->type   = 'select';
        $self->select = ['COUNT(*) AS cnt'];
        $result       = $self->execute();
        return count($result[0]) > 0 ? (int) $result[0]['cnt'] : 0;
    }

    /**
     * Get results
     *
     * @return array
     */
    public function getAll()
    {
        return $this->execute();
    }

    /**
     * Get single item
     *
     * @return mixed
     */
    public function getOne()
    {
        return $this->limit(1)->execute();
    }

    /**
     * Set limit
     *
     * @param int $limit
     */
    public function limit($limit)
    {
        if ($limit > 0) {
            parent::limit($limit);
        }
        return $this;
    }

    /**
     * Set offset
     *
     * @param int $offset
     */
    public function offset($offset)
    {
        if ($offset > 0) {
            parent::offset($offset);
        }
        return $this;
    }
}