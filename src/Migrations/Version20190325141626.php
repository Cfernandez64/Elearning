<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325141626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advance ADD content_id INT DEFAULT NULL, DROP contenu_id');
        $this->addSql('ALTER TABLE advance ADD CONSTRAINT FK_E7811BF384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('CREATE INDEX IDX_E7811BF384A0A3ED ON advance (content_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advance DROP FOREIGN KEY FK_E7811BF384A0A3ED');
        $this->addSql('DROP INDEX IDX_E7811BF384A0A3ED ON advance');
        $this->addSql('ALTER TABLE advance ADD contenu_id INT NOT NULL, DROP content_id');
    }
}
