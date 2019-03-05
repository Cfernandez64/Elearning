<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305162840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE contenu_cour RENAME INDEX idx_61d697bc3c1cc488 TO IDX_A121A82F3C1CC488');
        $this->addSql('ALTER TABLE contenu_cour RENAME INDEX idx_61d697bcf9295384 TO IDX_A121A82FB7942F03');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu DROP created_at');
        $this->addSql('ALTER TABLE contenu_cour RENAME INDEX idx_a121a82f3c1cc488 TO IDX_61D697BC3C1CC488');
        $this->addSql('ALTER TABLE contenu_cour RENAME INDEX idx_a121a82fb7942f03 TO IDX_61D697BCF9295384');
    }
}
