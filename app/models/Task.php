<?php

class Task {

    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private State $state,
        private DateTime $startTime,
        private ?DateTime $endTime, // "?" allows it to be null if the task has not been completed yet.
        private DateTime $creation_date,
        private int $idUser
    ){}

    // Getters: 

    public function getId(): int {return $this->id;}
    public function getName(): string {return $this->name;}
    public function getDescription(): string {return $this->description;}
    public function getState(): State {return $this->state;}
    public function getStartTime(): DateTime {return $this->startTime;}
    public function getEndTime(): ?DateTime {return $this->endTime;}
    public function getCreation_date(): DateTime {return $this->creation_date;}
    public function getIdUser(): int {return $this->idUser;}

    // Setters:

    public function setName(string $name): void {$this->name = $name;}
    public function setDescription(string $description): void {$this->description = $description;}
    public function setState(State $state): void {$this->state = $state;}
    public function setStartTime(DateTime $startTime): void {$this->startTime = $startTime;}
    public function setEndTime(DateTime $endTime): void {$this->endTime = $endTime;}
    // All setters except id, creation_date and idUser which are created when instanced and can't be modified. 

}

?>