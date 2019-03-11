<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190311090923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lessons_contents (id INT AUTO_INCREMENT NOT NULL, lesson_id INT DEFAULT NULL, content_id INT DEFAULT NULL, rank INT NOT NULL, INDEX IDX_AB7858C3CDF80196 (lesson_id), INDEX IDX_AB7858C384A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lessons_contents ADD CONSTRAINT FK_AB7858C3CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE lessons_contents ADD CONSTRAINT FK_AB7858C384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F36852A492');
        $this->addSql('DROP INDEX IDX_F87474F36852A492 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP rel_content_id');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A95C0D5857');
        $this->addSql('DROP INDEX IDX_FEC530A95C0D5857 ON content');
        $this->addSql('ALTER TABLE content DROP rel_lesson_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE lessons_contents');
        $this->addSql('ALTER TABLE content ADD rel_lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A95C0D5857 FOREIGN KEY (rel_lesson_id) REFERENCES cours_contenus (id)');
        $this->addSql('CREATE INDEX IDX_FEC530A95C0D5857 ON content (rel_lesson_id)');
        $this->addSql('ALTER TABLE lesson ADD rel_content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F36852A492 FOREIGN KEY (rel_content_id) REFERENCES cours_contenus (id)');
        $this->addSql('CREATE INDEX IDX_F87474F36852A492 ON lesson (rel_content_id)');
    }
}
