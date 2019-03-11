<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190311092017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE content_lesson (content_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_9042045F84A0A3ED (content_id), INDEX IDX_9042045FCDF80196 (lesson_id), PRIMARY KEY(content_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_lesson ADD CONSTRAINT FK_9042045F84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_lesson ADD CONSTRAINT FK_9042045FCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE content_lesson');
    }
}
