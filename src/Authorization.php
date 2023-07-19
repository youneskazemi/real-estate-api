<?php



class Authorization
{

    public function __construct(private int $role_id)
    {
    }


    public function is_admin(): bool
    {
        return $this->role_id === 1;
    }
    public function is_seller(): bool
    {
        return $this->role_id === 2;
    }

    public function is_member(): bool
    {
        return $this->role_id === 3;
    }
}
