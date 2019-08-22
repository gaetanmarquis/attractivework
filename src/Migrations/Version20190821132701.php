<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:src/Migrations/Version20190820140911.php
final class Version20190820140911 extends AbstractMigration
=======
final class Version20190821132701 extends AbstractMigration
>>>>>>> message:src/Migrations/Version20190821132701.php
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE membre ADD description_photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE messagze message LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE membre DROP description_photo');
        $this->addSql('ALTER TABLE message CHANGE message messagze LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
