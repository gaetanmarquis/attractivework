<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190830105512 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recruteur DROP FOREIGN KEY FK_2BD3678C6A99F74A');
        $this->addSql('ALTER TABLE recruteur ADD CONSTRAINT FK_2BD3678C6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recruteur DROP FOREIGN KEY FK_2BD3678C6A99F74A');
        $this->addSql('ALTER TABLE recruteur ADD CONSTRAINT FK_2BD3678C6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
    }
}
