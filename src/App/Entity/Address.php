<?php

namespace Mvc\Framework\App\Entity;

class Address
{
private int $id;
private string $street;
private int $street_number;
private int $zip_code;
private string $town;
private string $address_complement;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return int
     */
    public function getStreetNumber(): int
    {
        return $this->street_number;
    }

    /**
     * @param int $street_number
     */
    public function setStreetNumber(int $street_number): void
    {
        $this->street_number = $street_number;
    }

    /**
     * @return int
     */
    public function getZipCode(): int
    {
        return $this->zip_code;
    }

    /**
     * @param int $zip_code
     */
    public function setZipCode(int $zip_code): void
    {
        $this->zip_code = $zip_code;
    }

    /**
     * @return string
     */
    public function getTown(): string
    {
        return $this->town;
    }

    /**
     * @param string $town
     */
    public function setTown(string $town): void
    {
        $this->town = $town;
    }

    /**
     * @return string
     */
    public function getAddressComplement(): string
    {
        return $this->address_complement;
    }

    /**
     * @param string $address_complement
     */
    public function setAddressComplement(string $address_complement): void
    {
        $this->address_complement = $address_complement;
    }


}