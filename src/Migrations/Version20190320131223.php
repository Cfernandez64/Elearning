<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320131223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE advance (id INT AUTO_INCREMENT NOT NULL, stagiaire_id INT NOT NULL, percentage INT NOT NULL, UNIQUE INDEX UNIQ_E7811BF3BBA93DD6 (stagiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advance ADD CONSTRAINT FK_E7811BF3BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE contenu ADD advance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contenu ADD CONSTRAINT FK_89C2003FE24A7072 FOREIGN KEY (advance_id) REFERENCES advance (id)');
        $this->addSql('CREATE INDEX IDX_89C2003FE24A7072 ON contenu (advance_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contenu DROP FOREIGN KEY FK_89C2003FE24A7072');
        $this->addSql('DROP TABLE advance');
        $this->addSql('DROP INDEX IDX_89C2003FE24A7072 ON contenu');
        $this->addSql('ALTER TABLE contenu DROP advance_id');
    }
}
