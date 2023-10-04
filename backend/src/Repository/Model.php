<?php

namespace Bm\Store\Repository;

use Bm\Store\Database\Transaction;
use Bm\Store\Entity\Entity;
use Bm\Store\Util\JsonResponse;
use PDO;
use PDOException;
use ReflectionClass;

abstract class Model
{
    protected string $table;

    private function getEntity()
    {
        $reflection = new ReflectionClass(static::class);
        $class = $reflection->getShortName();
        $entity = "Bm\\Store\\Entity\\" . str_replace("Repository", "", $class);

        return $entity;
    }

    public function getAll(string $fields = '*')
    {
        try {
            Transaction::open();

            $conn = Transaction::getConnection();
            $query = $conn->prepare("select {$fields} from {$this->table}");
            $query->execute();

            $entity = $this->getEntity();
            $result = $query->fetchAll(PDO::FETCH_CLASS, $entity);

            Transaction::close();

            return $result;
        } catch (PDOException $e) {
            JsonResponse::send($e->getMessage(), 500);
            Transaction::rollback();
        }
    }

    public function getById($id, string $fields = '*')
    {
        try {
            Transaction::open();

            $conn = Transaction::getConnection();
            $query = $conn->prepare("SELECT {$fields} FROM {$this->table} WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $entity = $this->getEntity();
            $result = $query->fetchObject($entity);

            Transaction::close();

            return $result;
        } catch (PDOException $e) {
            JsonResponse::send($e->getMessage(), 500);
            Transaction::rollback();
        }
    }

    public function getWhere(string $where, $value, string $fields = '*')
    {
        try {
            Transaction::open();

            $conn = Transaction::getConnection();
            $query = $conn->prepare("SELECT {$fields} FROM {$this->table} WHERE {$where} = :value");
            $query->bindParam(':value', $value);
            $query->execute();

            $entity = $this->getEntity();
            $result = $query->fetchAll(PDO::FETCH_CLASS, $entity);

            Transaction::close();

            return $result;
        } catch (PDOException $e) {
            JsonResponse::send($e->getMessage(), 500);
            Transaction::rollback();
        }
    }

    public function getWhereIn(string $where, array $values, string $fields = '*')
    {
        try {
            Transaction::open();

            $conn = Transaction::getConnection();
            $placeholders = implode(',', array_fill(0, count($values), '?'));
            $query = $conn->prepare("SELECT {$fields} FROM {$this->table} WHERE {$where} IN ({$placeholders})");

            foreach ($values as $key => $value) {
                $query->bindValue($key + 1, $value);
            }

            $query->execute();

            $entity = $this->getEntity();
            $result = $query->fetchAll(PDO::FETCH_CLASS, $entity);

            Transaction::close();

            return $result;
        } catch (PDOException $e) {
            JsonResponse::send($e->getMessage(), 500);
            Transaction::rollback();
        }
    }


    public function create(Entity $entity)
    {
        try {
            Transaction::open();

            $conn = Transaction::getConnection();
            $fields = implode(', ', array_keys($entity->getAttributes()));
            $values = ':' . implode(', :', array_keys($entity->getAttributes()));

            $query = $conn->prepare("INSERT INTO {$this->table} ($fields) VALUES ($values)");

            $query->execute($entity->getAttributes());

            $lastInsertId = $conn->lastInsertId();

            Transaction::close();

            return $lastInsertId;
        } catch (PDOException $e) {
            JsonResponse::send($e->getMessage(), 500);
            Transaction::rollback();
        }
    }


    public function update($id, Entity $entity)
    {
        try {
            Transaction::open();

            $conn = Transaction::getConnection();
            $setFields = [];
            $data = $entity->getAttributes();

            foreach (array_keys($data) as $key) {
                $setFields[] = "$key = :$key";
            }

            $setFields = implode(', ', $setFields);

            $query = $conn->prepare("UPDATE {$this->table} SET $setFields WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }

            $response = $query->execute();

            Transaction::close();

            return $response;
        } catch (PDOException $e) {
            JsonResponse::send($e->getMessage(), 500);
            Transaction::rollback();
        }
    }


    public function delete($id)
    {
        try {
            Transaction::open();

            $conn = Transaction::getConnection();
            $query = $conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            Transaction::close();
        } catch (PDOException $e) {
            JsonResponse::send($e->getMessage(), 500);
            Transaction::rollback();
        }
    }
}
